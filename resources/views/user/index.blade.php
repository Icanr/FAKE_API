 <table  class="table table-bordered" border="1" style="background-color: skyblue">
 <a
  class="btn btn-primary" href="{{ route('users.create') }}"> Create</a>
 <thead>
     <tr align="center">
         <td>No</td>
         <td>FirstName</td>
         <td>LastName</td>
         <td>Action</td>
     </tr>
 </thead>
<tbody>

    @php
        $number = 1;
    @endphp
    @forelse($users['data'] as $user)
    @php
        $user_id = $user['id'];
    @endphp
    <tr>
        <td>{{ $number++ }}</td>
        <td>{{ $user['firstName'] }}</td>
        <td>{{ $user['lastName'] }}</td>
        <td align="center">
            <form action="{{route('users.destroy', $user['id'])}}" method="POST" id="delete_{{$user_id}}">
            <a href="{{ 'users/'.$user['id'] }}" class="text-primary"><i class="fa fa-fw fa-edit"></i> Edit</a> 
            @csrf
            @method('DELETE')
            <button type="submit" class="text-danger" onClick="return confirm('Are you sure to delete this user?'); document.getElementById('delete_{{$user_id}}')"><i class="fa fa-fw fa-trash"></i> Delete</button>
            </form>
        </td>

    </tr>
    @empty
        <tr><td colspan="6" align="center">No Record(s) Found!</td></tr>
    @endforelse
</tbody>
</table>

@if($users['total'] > $users['limit'])
<div>
    @php $pages = ceil($users['total'] / $users['limit']) @endphp
    @if (request('page') != 1 || is_null(request('page')))
        <a href="?page={{request('page') ? request('page') - 1 : '1'}}" aria-label="previous">
            <span>&laquo;</span>
        </a>
    @endif
    @for ($i = 1; $i < $pages; $i++)
        <a href="?page={{ $i }}">{{ $i }}</a>
    @endfor
    @if (request('page') != $pages - 1)
        <a href="?pages={{request('page') ? request('page') + 1 : $pages - 1 }}" aria-label="next">
            <span>&raquo;</span>
        </a>
    @endif
</div>
@endif

<!-- //di foreach dari $users['data'] karna biasanya response dari API itu di bungkus dalam index 'data'
-->