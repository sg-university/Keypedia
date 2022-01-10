@extends('templates.customerLayout')

@section('content')

    {{-- Konten --}}
    <div class="row text-center mb-3">
        <h2 class="my-4">Your Transaction History</h2>
    </div>

    <div class="container d-flex justify-content-center">
        <div class="col-md-2">
            <div class="row justify-content-center">
                @forelse ($userTransactions as $transaction)
                    <form action="{{ route('customer.transaction.detail.index', ['id' => $transaction->id]) }}"
                        method="get">
                        <button type="submit" class="btn btn-secondary mb-4">Transaction at
                            {{ $transaction->updated_at }}</button>
                    </form>
                @empty
                    <h4>Empty</h4>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Akhir konten --}}
@endsection
