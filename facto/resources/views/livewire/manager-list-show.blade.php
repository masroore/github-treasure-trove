<div>
 
    @include('managers.list-show',[
        'managers'=> $managers,
        'manager'=> $manager ?? null,
    ])
</div>
