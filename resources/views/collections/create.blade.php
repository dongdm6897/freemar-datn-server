@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Collection </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('collections.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('collections.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Image:</strong>
                    <textarea class="form-control" style="height:150px" name="image" placeholder="Image"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="form-control" style="height:150px" name="description" placeholder="Description"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Search keywords:</strong>
                    <textarea class="form-control" style="height:150px" name="search_keywords" placeholder="Search Keywords"></textarea>
                </div>
            </div>

            <div class='col-sm-6'>
                <div class="form-group">
                    <label for="">Valid from</label>
                    <div class='input-group date' id='date_valid_form'>
                        <input name="valid_from" type='text' class="form-control" />
                        <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </span>
                    </div>
                </div>
            </div>

            <div class='col-sm-6'>
                <div class="form-group">
                    <label for="">Valid to</label>
                    <div class='input-group date' id='date_valid_to'>
                        <input name="valid_to" type='text' class="form-control" />
                        <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

        <script>
            $( function() {
                $('.date').datetimepicker(

                );
            });
        </script>

    </form>
@endsection