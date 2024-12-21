@extends('components.layout')
@section('title', 'Keranjang')
@section('content')

  <body>

    <h1 class="text-center font-bold text-xl mt-6">Keranjang</h1>
    @if (session()->has('error'))
      <div class="container text-center py-3 mt-2 mb-3 lg:w-1/3  mx-auto rounded-lg bg-red-300 text-red-900 w-full">
        {{ session('error') }}
      </div>
    @endif
    <div class="container mx-auto md:px-2 my-5 grid lg:flex items-start px-4">
      <div class="relative shadow-md sm:rounded-lg overflow-x-auto w-2/3 hidden lg:block">
        <table class="w-full">
          <thead class="bg-gray-100 border-b-2 border-gray-300">
            <tr>
              <th class="w-24 p-3 tracking-wide text-left">Kode</th>
              <th class="p-3 tracking-wide text-left">Produk</th>
              <th class="w-28 p-3 tracking-wide text-left">Kuantitas</th>
              <th class="w-28 p-3 tracking-wide text-left">Harga</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-300">
            {{-- foreach here --}}
            @foreach ($carts as $cart)
              @php
                $pictures = json_decode($cart->product->pictures);
              @endphp
              <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                <td class="p-3 text-gray-500 font-semibold whitespace-nowrap">
                  {{ $cart->product->code }}
                </td>
                <td class="p-3 text-gray-500 font-semibold whitespace-nowrap">
                  <div class="flex flex-space-4 items-center">
                    <img src="{{ asset('storage/' . $pictures[0]) }}" class="h-24 w-24 sm:h-14 sm:w-14 mr-4 object-cover rounded-md">
                    {{ $cart->product->name }}
                  </div>
                </td>
                <td class="p-3 text-gray-500 font-semibold whitespace-nowrap">
                  <div class="flex flex-space-4 items-center justify-between">
                    <form action="{{ route('subqty', ['cart_id' => $cart->id]) }}" method="POST">
                      @csrf
                      <button type="submit" name="decrease" class="size-9 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-200 text-sm transition-colors duration-150">
                        <i class="fa-solid fa-minus"></i>
                      </button>
                    </form>
                    <form action="{{ route('editqty', ['cart_id' => $cart->id]) }}" class="mx-4 w-14" method="POST">
                      @csrf
                      <input type="number" name="quantity" value="{{ old('quantity', $cart->quantity) }}" class="rounded w-full h-7 py-4 text-center" inputmode="numeric" style="-moz-appearance: textfield">
                      <button type="submit" class="hidden"></button>
                    </form>
                    <form action="{{ route('addqty', ['cart_id' => $cart->id]) }}" method="POST">
                      @csrf
                      <button type="submit" name="increase" class="size-9 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-200 text-sm transition-colors duration-150">
                        <i class="fa-solid fa-plus"></i>
                      </button>
                    </form>
                  </div>
                </td>
                <td class="p-3 text-blue-500 font-semibold whitespace-nowrap">
                  Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="grid grid-cols-2">
        @foreach ($carts as $cart)
        @endforeach
      </div>

      <div class="border border-slate-600 flex-1 lg:ml-5 rounded-lg bg-blue-100 flex-shrink-0">
        <h1 class="p-3 text-center font-semibold">Ringkasan Belanja</h1>
        <div class="p-8 border border-y-slate-600">
          @foreach ($carts as $cart)
            <div class="flex justify-between">
              <p>{{ $cart->product->name }} <span class="text-red-600 ml-4">x{{ $cart->quantity }}</span></p>
              <p>Rp {{ number_format($cart->total_price, 0, ',', '.') }}</p>
            </div>
          @endforeach
        </div>
        <div class="px-8 py-5">
          <div class="flex justify-between font-semibold">
            <p>Total</p>
            @php
              $total_price = App\Models\Cart::sum('total_price');
            @endphp
            <p>Rp {{ number_format($total_price, 0, ',', '.') }}</p>
          </div>
          <div class="flex justify-center">
            <a href="{{}}" class="w-full">
              <div class="text-center mt-4 border rounded-lg w-full py-2 bg-blue-600 hover:bg-blue-800 transition-colors text-white font-semibold cursor-pointer">
                Beli
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </body>
@endsection
