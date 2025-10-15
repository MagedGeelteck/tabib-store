@if (count($breadcrumbs))
    <ol class="breadcrumb" v-pre>
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
                <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @else
                <li class="breadcrumb-item active">{{ Str::limit($breadcrumb->title, 60) }}</li>
            @endif
        @endforeach
    </ol>
@endif

<br><br>
@if(Route::current()->getName()=='orders.index')
    <ol class="breadcrumb delete-icon">
        

        
        <li><a href="/admin/orders?status=all" class="btn btn-default me-1" 
        @if(!empty($_GET['status'])&&$_GET['status']=="all")style="border:2px solid green";@endif
        ><i class="fa fa-check-circle"></i> <b>All</b></a></li>
        
        <li class=""><a href="/admin/orders?status=pending" class="btn btn-default me-1"
        @if(!empty($_GET['status'])&&($_GET['status']=="pending"))style="border:2px solid green";@endif
        @if(empty($_GET['status']))style="border:2px solid green";@endif
        ><i class="fa fa-check-circle"></i> <b>New</b></a></li>
        
        <li class=""><a href="/admin/orders?status=completed" class="btn btn-default me-1"
        @if(!empty($_GET['status'])&&$_GET['status']=="completed")style="border:2px solid green";@endif
        ><i class="fa fa-check-circle"></i> <b>Completed</b></a></li>
        
        

    </ol>
@endif