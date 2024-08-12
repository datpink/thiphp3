@extends('layouts.master')
@section('title')
    Edit Room {{ $room->name}}
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Type</label>
            <select name="type_id" class="form-control">
                @foreach ($types as $id => $name)
                    <option @selected($room->type_id === $id) value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ $room->name }}" class="form-control">
        </div>
        <div class="form-group">
            <label>Describe</label>
            <textarea name="describe"cols="30" rows="5" class="form-control">{{ $room->describe }}</textarea>
        </div>
        <div class="form-group">
            <label>Is Active</label>
            <select name="is_active" class="form-control">
                <option @selected($room->is_active == 1) value="1">True</option>
                <option @selected($room->is_active == 0) value="0">False</option>
            </select>
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
            <br>
            @if ($room->image && \Storage::exists($room->image))
                <img src="{{ \Storage::url($room->image) }}" alt="" width="150">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
