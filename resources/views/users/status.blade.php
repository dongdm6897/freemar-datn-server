@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>User status</h2>
            </div>
            <div class="pull-left">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $user->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {{ $user->email }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Status:</strong>
                {{$user->status_id}}
                {{$status_name}}

            </div>
            @if ($user->status_id === \App\Enums\UserStatusEnum::MEDIUM_WAITING_FOR_VERIFICATION or $user->status_id == \App\Enums\UserStatusEnum::MEDIUM)

                <form action="{{ route('users.updateStatus',$user->id) }}" method="POST">
                    @csrf

                    <div class="row align-items-center justify-content-center">
                        @if ($photo_type === 1)
                            <strong>ID image</strong>

                        @elseif ($photo_type === 2)
                            <strong> Passport image</strong>

                        @else
                            <strong>Driver licence image</strong>

                        @endif
                    </div>
                    <div class="row">

                        <div class="container">
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#myCarousel" data-slide-to="1"></li>
                                </ol>

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <img src="{{$photo_back_image_link}}" alt="Los Angeles">
                                        <div class="carousel-caption">
                                            <h3>Front</h3>
                                        </div>
                                    </div>

                                    <div class="item">
                                        <img src="{{$photo_back_image_link}}" alt="Chicago">
                                        <div class="carousel-caption">
                                            <h3>Back</h3>
                                        </div>
                                    </div>

                                </div>

                                <!-- Left and right controls -->
                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary" name="action" value="accept">Accept</button>
                            <button type="submit" class="btn btn-primary" name="action" value="decline">Decline</button>
                        </div>


                    </div>

                </form>
            @endif
            @if ($user->status_id == \App\Enums\UserStatusEnum::HIGH_WAITING_FOR_VERIFICATION)
                <form action="{{ route('users.updateStatus',$user->id) }}" method="POST">
                    @csrf
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary" name="action" value="accept">Accept</button>
                    <button type="submit" class="btn btn-primary" name="action" value="decline">Decline</button>
                </div>
                </form>
            @endif
            <div>

            </div>
        </div>


    </div>

@endsection