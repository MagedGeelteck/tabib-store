<?php

namespace Botble\Ecommerce\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use Botble\Base\Facades\BaseHelper;
use Botble\ACL\Traits\RegistersUsers;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Http\Requests\RegisterRequest;
use Botble\Ecommerce\Repositories\Interfaces\CustomerInterface;
use Botble\JsValidation\Facades\JsValidator;
use Carbon\Carbon;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\URL;
use DB;
use Session;
class RegisterController extends Controller
{
    use RegistersUsers;

    protected string $redirectTo = '/';

    public function __construct(protected CustomerInterface $customerRepository)
    {
        $this->middleware('customer.guest');
    }

    public function showRegistrationForm()
    {
        SeoHelper::setTitle(__('Register'));

        Theme::breadcrumb()->add(__('Home'), route('public.index'))->add(__('Register'), route('customer.register'));

        if (! session()->has('url.intended') &&
            ! in_array(url()->previous(), [route('customer.login'), route('customer.register')])
        ) {
            session(['url.intended' => url()->previous()]);
        }

        Theme::asset()
            ->container('footer')
            ->usePath(false)
            ->add('js-validation', 'vendor/core/core/js-validation/js/js-validation.js', ['jquery']);

        add_filter(THEME_FRONT_FOOTER, function ($html) {
            return $html . JsValidator::formRequest(RegisterRequest::class)->render();
        });

        return Theme::scope('ecommerce.customers.register', [], 'plugins/ecommerce::themes.customers.register')
            ->render();
    }

    public function register(Request $request, BaseHttpResponse $response)
    {
        $this->validator($request->input())->validate();

        do_action('customer_register_validation', $request);

        $customer = $this->create($request->input());

        event(new Registered($customer));

        if (EcommerceHelper::isEnableEmailVerification()) {
            $this->registered($request, $customer);

            return $response
                    ->setNextUrl(route('customer.login'))
                    ->setMessage(__('We have sent you an email to verify your email. Please check and confirm your email address!'));
        }

        $customer->confirmed_at = Carbon::now();
        $this->customerRepository->createOrUpdate($customer);
        $this->guard()->login($customer);

        return $response->setNextUrl($this->redirectPath())->setMessage(__('Registered successfully!'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, (new RegisterRequest())->rules());
    }

    protected function create(array $data)
    {
        return $this->customerRepository->create([
            'name' => BaseHelper::clean($data['name']),
            'email' => BaseHelper::clean($data['email']),
            'phone' => BaseHelper::clean($data['phone']),
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function guard()
    {
        return auth('customer');
    }

    public function confirm(int|string $id, Request $request, BaseHttpResponse $response, CustomerInterface $customerRepository)
    {
        if (! URL::hasValidSignature($request)) {
            abort(404);
        }

        $customer = $customerRepository->findOrFail($id);

        $customer->confirmed_at = Carbon::now();
        $this->customerRepository->createOrUpdate($customer);

        $this->guard()->login($customer);

        return $response
            ->setNextUrl(route('customer.overview'))
            ->setMessage(__('You successfully confirmed your email address.'));
    }

    public function resendConfirmation(
        Request $request,
        CustomerInterface $customerRepository,
        BaseHttpResponse $response
    ) {
        $customer = $customerRepository->getFirstBy(['phone' => $request->input('phone')]);

        if (! $customer) {
            return $response
                ->setError()
                ->setMessage(__('Cannot find this customer!'));
        }

        $FourDigitRandomNumber = rand(1231,7879);
        $Number =$request->input('phone');
        $message="Your Verification Code is :".$FourDigitRandomNumber;
        $message = str_replace(' ', '%20', $message);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://josmsservice.com/SMSServices/Clients/Prof/RestSingleSMS/SendSMS?senderid=tabib%20store&numbers=$Number&accname=tabibstore&AccPass=lN9lL0@hQ4uN@9cP9v&msg=$message");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $headers = array();
        $headers[] = "Accept: application/json";
        $headers[] = "Authorization: Bearer APIKEY";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close ($ch);
        
        Session::put('CodeSent',true);
        DB::table('ec_customers')->where('phone',$request->input('phone'))->update(['email_verify_token'=>$FourDigitRandomNumber]);

        return $response
            ->setMessage(__('We sent you another confirmation email. You should receive it shortly.'));
    }
}
