<ul>
    @foreach($childs as $child)
        <li class="user-{{ $child->id }}">
            <i class="fa fa-file " style="font-size: 20px !important;"></i> {{$child->account_number}}
            -{{ $child->account_name }}
            @if(count($child->childs))
                @include('client.accounting_tree.manageChild',['childs' => $child->childs])
            @endif
        </li>
    @endforeach
</ul>

