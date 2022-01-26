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
            @foreach($sqls as $sql)
            <div class="col mac">
                <label class="label-m">Machine ID</label>
                <input type="text" class="input-m form-control" value="{{$sql->machine_id}}" disabled>
            </div>
            <div class="col mac">
            <label class="label-m">Location</label>
                <input type="text" class="input-m form-control" value="{{$sql->latitude}},{{$sql->longitude}}" disabled>
            </div>
            @endforeach
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
                    <button class="btn btn-warning">Edit</button>
                    <button class="btn btn-danger">Delete</button>
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
                <form>
                    <div class="mb-3">
                        <label for="" class="form-label">Machine ID</label>
                        <input type="text" class="form-control" id="set_id">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Latitude</label>
                        <input type="text" class="form-control" id="set_lat">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Longitude</label>
                        <input type="text" class="form-control" id="set_long">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-danger" onclick="clossAdd()">Cancle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="edit-background">
    <div id="edit-form" class="col-5">
        <div class="card">
            <div class="card-header">
                <h5 style="text-align:center">Edit Machine Location</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="" class="form-label">Machine ID</label>
                        <input type="text" class="form-control" value="{{$sql->machine_id}}" disabled>
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
                        <button type="button" class="btn btn-danger" onclick="clossAdd()">Cancle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="toru"></div>
</div>
@endsection
