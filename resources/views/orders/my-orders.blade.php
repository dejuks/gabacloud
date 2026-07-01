@extends('layouts.app')


@section('title','My Orders')


@section('content')

<div class="container mx-auto py-8">


    <h1 class="text-3xl font-bold mb-6">
        My Orders
    </h1>


    @foreach($orders as $order)


        <div class="bg-white shadow rounded p-5 mb-4">


            <div class="flex justify-between">


                <div>

                    <h2 class="font-bold text-xl">

                        {{ $order->product->title }}

                    </h2>


                    <p>
                        Amount:
                        {{ number_format($order->amount,2) }} ETB
                    </p>


                    <p>
                        Transaction:
                        {{ $order->tx_ref }}
                    </p>


                </div>



                <div>


                    @if($order->status=='paid')

                        <span class="text-green-600 font-bold">
                            Paid
                        </span>


                    @else

                        <span class="text-yellow-600">
                            {{ $order->status }}
                        </span>


                    @endif


                </div>


            </div>



            <div class="mt-4">


                <a href="{{ route('orders.show',$order) }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded">

                    Details

                </a>


                @if($order->status=='paid')


                    <a href="{{ route('orders.download',$order) }}"
                        class="bg-green-600 text-white px-4 py-2 rounded ml-2">

                        Download

                    </a>


                @endif


            </div>



        </div>


    @endforeach


    {{ $orders->links() }}


</div>


@endsection
