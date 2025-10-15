<<<<<<< HEAD
<x-notification-plus::setting-form name="slack">
    <div class="mb-3 form-group">
        <label class="text-title-field">{{ trans('plugins/notification-plus::notification-plus.slack.settings.webhook_url') }}</label>
        <input type="text" name="{{ NotificationPlus::getSettingKey($name, 'webhook_url') }}" class="next-input" value="" placeholder="REDACTED_URL_PLACEHOLDER">
=======
<x-notification-plus::setting-form
    :$name
    :$driver
    :$validator
    :title="trans('plugins/notification-plus::notification-plus.slack.settings.title')"
    :description="trans('plugins/notification-plus::notification-plus.slack.settings.description', ['link' => Html::link('https://api.slack.com/messaging/webhooks', 'tutorial', ['target' => '_blank'])])"
>
    <div class="mb-3 form-group">
        <label class="text-title-field">{{ trans('plugins/notification-plus::notification-plus.slack.settings.webhook_url') }}</label>
        <input type="text" name="{{ NotificationPlus::getSettingKey($name, 'webhook_url') }}" class="next-input" value="" placeholder="E.g: REDACTED_SLACK_WEBHOOK">
>>>>>>> e9e0a5a (Initial commit)
        {!! Form::helper(trans('plugins/notification-plus::notification-plus.slack.settings.webhook_url_instruction', ['link' => Html::link('https://t.me/BotFather', '@BotFather', ['target' => '_blank'])->toHtml()])) !!}
    </div>
</x-notification-plus::setting-form>
