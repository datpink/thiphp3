@extends('layouts.master')
@section('title')
    List Room
@endsection
@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif
    <a href="{{ route('rooms.create') }}"><button class="btn btn-primary mt-3 mb-3">Crate New Room</button></a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Describe</th>
                <th>Type Name</th>
                <th>Is Active</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rooms as $room)
                <tr>
                    <td>
                        @if ($room->image && \Storage::exists($room->image))
                            <img src="{{ \Storage::url($room->image) }}" alt="" width="150">
                        @endif
                    </td>
                    <td>{{ $room->name }}</td>
                    <td>{{ $room->describe }}</td>
                    <td>{{ $room->type->name }}</td>
                    <td>
                        @if ($room->is_active === 1)
                            True
                        @elseif ($room->is_active === 0)
                            False
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('rooms.edit', $room) }}"><button class="btn btn-warning">Edit</button></a>
                        <form action="{{ route('rooms.destroy', $room) }}" method="POST" style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return(confirm('Chắc chưa ?'))">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $rooms->links() }}
@endsection
