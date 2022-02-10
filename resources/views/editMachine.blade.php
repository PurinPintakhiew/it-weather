@extends('layouts.app')

@section('content')
<div class="container col-6">
        <div id="edit-form">
            <div class="card" style="font-weight: 600;">
                <div class="card-header">
                    <h5 style="text-align:center;font-weight: 600;">Edit Machine Location</h5>
                </div>
                <div class="card-body">
                    @if(Session::has('Machine_up'))
                        <div class="alert alert-success" role="alert">
                            {{Session::get('Machine_up')}}
                        </div>
                    @endif
                    <form  action="{{route('editMac')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                        @foreach($sql as $sql)
                        <input type="hidden" class="form-control" value="{{$sql->machine_id}}" name="id">
                        <div class="mb-3">
                            <label for="" class="form-label">Machine name</label>
                            <input type="text" class="form-control" value="{{$sql->machine_name}}" name="set_name">
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="" class="form-label">Latitude</label>
                                <input type="text" class="form-control" value="{{$sql->latitude}}" name="set_lat">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Longitude</label>
                                <input type="text" class="form-control" value="{{$sql->longitude}}" name="set_long">
                            </div>
                        </div>
                        <div class="mb-3">
                                <label for="" class="form-label">Address</label>
                                <input type="text" class="form-control" value="{{$sql->address}}" name="set_address">
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="" class="form-label">Topic Status Machine</label>
                                <input type="text" class="form-control" value="{{$sql->topic_status}}" name="topic_status">
                            </div>
                            <div class="col mb-3">
                                <label for="" class="form-label">Topic PM</label>
                                <input type="text" class="form-control"  value="{{$sql->topic_pm}}" name="topic_pm">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="" class="form-label">Topic Temperature</label>
                                <input type="text" class="form-control" value="{{$sql->topic_temp}}" name="topic_temp">
                            </div>
                            <div class="col mb-3">
                                <label for="" class="form-label">Topic Humidity</label>
                                <input type="text" class="form-control" value="{{$sql->topic_hum}}" name="topic_hum">
                            </div>
                        </div>
                        @endforeach
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a type="button" class="btn btn-danger" href="/dashboard">Cancle</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection