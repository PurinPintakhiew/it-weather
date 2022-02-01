@extends('layouts.app')

@section('content')
<div class="container col-5">
        <div id="edit-form">
            <div class="card">
                <div class="card-header">
                    <h5 style="text-align:center">Edit Machine Location</h5>
                </div>
                <div class="card-body">
                    <form>
                        @foreach($sql as $sql)
                        <div class="mb-3">
                            <label for="" class="form-label">Machine ID</label>
                            <input type="text" class="form-control" value="{{$sql->machine_id}}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Machine name</label>
                            <input type="text" class="form-control" value="{{$sql->machine_name}}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Latitude</label>
                            <input type="text" class="form-control" value="{{$sql->latitude}}" id="edit_lat">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Longitude</label>
                            <input type="text" class="form-control" value="{{$sql->longitude}}" id="edit_long">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a type="button" class="btn btn-danger" href="/home">Cancle</a>
                        </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection