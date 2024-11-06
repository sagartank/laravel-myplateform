<hr>
@if(isset($groupRelationUsers))
    @foreach($groupRelationUsers as $key=>$relations)
    <ul class="users-relation-ul">
        <li>{{$key}}
            <ul>
                @foreach($relations as $relation)
                    <li>{{$relation->buyer}}</li>
                @endforeach
            </ul>
        </li>
    </ul>
    @endforeach
@endif