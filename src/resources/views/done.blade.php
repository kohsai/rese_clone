@extends('layouts.app')

@section('content')

<div class="reserve-thanks">ご予約ありがとうございます</div>
    <div class="reservebtn-container">
        <a href="{{ route('shops.index') }}" >戻る</a>
    </div>

@endsection

