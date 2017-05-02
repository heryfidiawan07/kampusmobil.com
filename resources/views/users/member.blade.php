@extends('layouts.app')

@section('content')
<div class="row">
<h3 class="text-center"><u> Daftar Member </u></h3><br>
    @foreach($members as $member)
	    <div class="col-md-4">
        <div class="well">
      		<div class="media">
            <a href="/member/{{$member->slug}}" class="pull-left">
              <img src="{{$member->avatar() }}" class="img-responsive" width="150">
            </a>
            <a href="/member/{{$member->slug}}">
              <p>{{$member->name}}</p>
            </a>
            <p><small>Joined : {{$member->created_at->diffForHumans()}}</small> </p>
  				</div>
        </div>
	    </div>
    @endforeach
</div>
<div class="row">
  <div class="text-center">
    {{$members->links()}}
  </div>
</div>
    
@endsection

