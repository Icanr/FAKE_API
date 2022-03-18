@extends('layout.awal')
     
@section('content')
<style>
        .ica{
            background-color : gainsboro;
        }
    </style>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Data Admin</h2>
            </div>
            <div class="pull-right" style="margin-left:20px">
                <a class="btn btn-primary" href="{{ route('users.create') }}"> Create</a>
            </div>
        </div>
    </div>
    <br>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div style="margin:30px">
    <table class="table table-bordered">
    @php
        $number = 1;
    @endphp
    <tr>
        <td>{{ $number++ }}</td>
        <td>{{ $userfirstName'] }}</td>
        <td>{{ $user['lastName'] }}</td>
        <td align="center">
            <a href="{{ 'users/'.$user['id'] }}" class="text-primary"><i class="fa fa-fw fa-edit"></i> Edit</a> |
            <!-- //modify button delete yg ada dalam table html sebelumnya menjadi: -->
            <form method="POST" action="{{ 'users/'.$user['id'] }}">
             @method('DELETE')
             @csrf

            <a href="{{ 'users/'.$user['id'] }}" class="text-primary"><i class="fa fa-fw fa-edit"></i> Edit</a> |
            <button type="submit" class="text-danger btn btn-link" onClick="return confirm('Are you sure to delete this user?');"><i class="fa fa-fw fa-trash"></i> Delete</button>
            </form>
        </td>

    </tr>
    </table>
    </div>
    {!! $users->links() !!}
        
@endsection