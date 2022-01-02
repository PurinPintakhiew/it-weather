<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootsrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <!-- css -->
    <link rel="stylesheet" type="text/css" href="{{ url('/css/styles.css') }}" /> 
    <title>ข้อมูลย้อนหลัง</title>
</head>
<body>
    <div class="container fluid">
        <h1>ข้อมูลย้อนหลัง</h1>

        <form action="{{ route('see') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12 col-lg-4 part1">
                <label for=""  class="form-label" >วันที่เริ่มต้น</label>
                <div class="row">
                    <input  type="date" class="form-control col" name="date1">
                    <select  class="form-select col" name="time1">
                        <option value="00:00">00:00</option>
                        <option value="01:00">01:00</option>
                        <option value="02:00">02:00</option>
                        <option value="03:00">03:00</option>
                        <option value="04:00">04:00</option>
                        <option value="05:00">05:00</option>
                        <option value="06:00">06:00</option>
                        <option value="07:00">07:00</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                        <option value="19:00">19:00</option>
                        <option value="20:00">20:00</option>
                        <option value="21:00">21:00</option>
                        <option value="22:00">22:00</option>
                        <option value="23:00">23:00</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 col-lg-1 part2">
                    <p>to</p>
            </div>
            <div class="col-md-12 col-lg-4 part3">
                <label for=""  class="form-label" >วันที่สิ้นสุด</label>
                <div class="row">
                    <input type="date" class="form-control col" name="date2">
                    <select  class="form-select col" name="time2">
                        <option value="00:00">00:00</option>
                        <option value="01:00">01:00</option>
                        <option value="02:00">02:00</option>
                        <option value="03:00">03:00</option>
                        <option value="04:00">04:00</option>
                        <option value="05:00">05:00</option>
                        <option value="06:00">06:00</option>
                        <option value="07:00">07:00</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                        <option value="19:00">19:00</option>
                        <option value="20:00">20:00</option>
                        <option value="21:00">21:00</option>
                        <option value="22:00">22:00</option>
                        <option value="23:00">23:00</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 col-lg-3 part4">
                <button type="submit" class="btn btn-primary">ตรวจสอบ</button>
            </div>
        </div>
        </form>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>date</th>
                    <th>pm</th>
                </tr>
            </thead>
            <tbody>
            @if($sql != null)
            @foreach($sql as $sql)
                <tr>
                    <td>{{$sql->datetime}}</td>
                    <td>{{$sql->pm2_5}}</td>
                </tr>
            @endforeach
            @endif
            </tbody>
        </table>
    </div>

    </div>
</body>
</html>