<div class="education layout-spacing">
    <div class="widget-content widget-content-area">
        <div class="text-center">
            @php 
                $routeName = Route::currentRouteName() 
            @endphp
            <img src="{{ route('image.process.establishment',['filename'=>$branch->logo]) }}" width="150px">
            <h4 class="branch-name">{{ $branch->name }}</h4>
            <p class="mb-0">{{ $branch->est_code }}</p>
            <p class="mb-0">{{ $branch->account->fullAddress }}</p>
        </div>
        <div class="list-group mt-3">
            <a href="{{ route('es.branch.single', ['est_code'=>$branch->est_code]) }}" class="list-group-item list-group-item-action {{ $routeName == 'es.branch.single'?'active':'' }}">
                Home
            </a>
            <a href="{{ route('es.branch.single.visitor.log', ['est_code'=>$branch->est_code]) }}" class="list-group-item list-group-item-action {{ $routeName == 'es.branch.single.visitor.log'?'active':'' }}">
                Visitor Logs
            </a>
            <a href="{{ route('es.branch.single.assigned.employee', ['est_code'=>$branch->est_code]) }}" class="list-group-item list-group-item-action {{ $routeName == 'es.branch.single.assigned.employee'?'active':'' }}">
                Assigned Employees
            </a>
            <a href="{{ route('es.branch.single.scanner', ['est_code'=>$branch->est_code]) }}" class="list-group-item list-group-item-action {{ $routeName == 'es.branch.single.scanner'?'active':'' }}">
                Scanners
            </a>
        </div>
    </div>
</div>