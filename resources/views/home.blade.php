@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-control">
        <div class="status-p">
            <span id="status">Not Connect</span>
        </div>
        <div class="control-mode">
            <p>Auto Mode</p>
            <label class="switch">
                <input type="checkbox" id="checkbox_on" onclick="setCheckbox()">
                <span class="slider round"></span>
            </label>
        </div>
        <div class="machine row">
            <div class="col-6 mac">
                <label class="label-m">Machine ID</label>
                <select class="form-select" id="select-topic">
                    @foreach($sqls as $sql)
                    <option value="{{$sql->machine_name}}">{{$sql->machine_name}}</option>
                    @endforeach
                </select>
            </div>
            <!-- <div class="col mac">
                <label class="label-m">Location</label>
                <input type="text" class="input-m form-control"  disabled>
            </div> -->
        </div>
        <div class="row">

            <div class="col pm-box">
                <p>PM 2.5</p>
                <div class="pm-body d-flex justify-content-center">
                    <h1 id="pm">0.00</h1>
                    <span class="pm-symbol">µg/&#13221</span>
                </div>
            </div>
            <div class="col temp-box">
                <p>Temperature</p>
                <div class="temp-body d-flex justify-content-center">
                    <h1 id="temp">0.00</h1>
                    <span class="pm-symbol">&#8451</span>
                </div>
            </div>
            <div class="col hum-box ">
                <p>Humidity</p>
                <div class="hum-body d-flex justify-content-center">
                    <h1 id="hum">0.00</h1>
                    <span class="pm-symbol">%</span>
                </div>
            </div>

        </div>
    </div>

    <table class="table">
        <thead class="table-h">
            <tr>
                <th>Machine ID</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="table-b">
            @foreach($sqls as $sql)
            <tr>
                <td class="table-d">{{$sql->machine_id}}</td>
                <td  class="table-d">{{$sql->latitude}}</td>
                <td  class="table-d">{{$sql->longitude}}</td>
                <td style="text-align:center">
                    <a class="btn btn-warning" href="/edit/{{$sql->machine_id}}">Edit</a>
                    <button class="btn btn-danger" onclick="showDelete({{$sql->machine_id}})">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="">
        <button id="showAdd" type="button" class="btn btn-success" onclick="showAdd()">Add Machine</button>
    </div>

<div id="dialog-background">
    <div id="dialog-form" class="col-5">
        <div class="card">
            <div class="card-header">
                <h5 style="text-align:center">Add Machine Location</h5>
            </div>
            <div class="card-body">
            @if(Session::has('Machine_add'))
                <div class="alert alert-success" role="alert">
                    {{Session::get('Book_add')}}
                </div>
            @endif
                <form  action="{{route('saveMac')}}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Machine name</label>
                        <input type="text" class="form-control" name="set_name">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Latitude</label>
                        <input type="text" class="form-control" name="set_lat">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Longitude</label>
                        <input type="text" class="form-control" name="set_long">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-danger" onclick="closs()">Cancle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="dialog-delete">
    <div id="dialog-form" class="col-md-2 col-sm-5">
        <div class="card">
            <div class="card-header" style="text-align:center">
               <p>You confirm to delete</p>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-evenly">
                    <button type="submit" class="btn btn-primary" onclick="deleteMac()">Yes</button>
                    <button class="btn btn-danger" onclick="closs()">No</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="toru"></div>
</div>


@endsection
