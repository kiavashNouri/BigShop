@extends('profile.layout')

@section('main')
    <table class="table">
        <tbody>
        <tr>
            <th>شماره سفارش</th>
            <th>تاریخ ثبت</th>
            <th>وضعیت سفارش</th>
            <th>کد رهگیری پستی</th>
            <th>اقدامات</th>
        </tr>

        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ jdate($order->created_at)->format('%d %B %Y') }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->tracking_serial ?? 'هنوز ثبت نشده' }}</td>
                <td>
                    <a href="{{ route('profile.orders.detail', $order->id) }}" class="btn btn-sm btn-info">جزئیات سفارش</a>
                    @if($order->status == 'unpaid')
                        <a href="{{ route('profile.orders.payment' , $order->id) }}" class="btn btn-sm btn-warning">پرداخت سفارش</a>
                    @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    {{ $orders->render() }}
@endsection
