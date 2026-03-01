@extends('dashboard.app')

@section('title', 'All Reviews')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-200">All Product Reviews</h1>

    @include('Alert.alert')

    <div class="overflow-x-auto bg-slate-800 rounded-lg shadow-xl border border-slate-700">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-slate-700/50 text-left">
                    <th class="py-3 px-4 border border-slate-700 text-sm font-semibold text-gray-300">#</th>
                    <th class="py-3 px-4 border border-slate-700 text-sm font-semibold text-gray-300">User</th>
                    <th class="py-3 px-4 border border-slate-700 text-sm font-semibold text-gray-300">Product</th>
                    <th class="py-3 px-4 border border-slate-700 text-sm font-semibold text-gray-300">Review</th>
                    <th class="py-3 px-4 border border-slate-700 text-sm font-semibold text-gray-300">Reply</th>
                    <th class="py-3 px-4 border border-slate-700 text-sm font-semibold text-gray-300">Date</th>
                    <th class="py-3 px-4 border border-slate-700 text-sm font-semibold text-gray-300">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reviews as $index => $review)
                    <tr class="border-t border-slate-700 hover:bg-slate-700/30 transition-colors">
                        <td class="py-3 px-4 border border-slate-700 text-gray-300">{{ $reviews->firstItem() + $index }}</td>
                        <td class="py-3 px-4 border border-slate-700 text-gray-300">{{ $review->user->name }}</td>
                        <td class="py-3 px-4 border border-slate-700 text-gray-300">{{ $review->product->name }}</td>
                        <td class="py-3 px-4 border border-slate-700 text-gray-300">{{ $review->review_details }}</td>

                        <td class="py-3 px-4 border border-slate-700">
                            @if(auth()->user()->role === 'admin')
                                <form class="reply-form" data-review-id="{{ $review->id }}">
                                    @csrf
                                    <textarea name="reply" class="bg-slate-700 border border-slate-600 text-gray-200 placeholder-gray-400 p-2 w-full rounded-lg mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="2" placeholder="Write a reply...">{{ $review->reply->reply ?? '' }}</textarea>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm transition-colors">
                                        {{ $review->reply ? 'Update Reply' : 'Send Reply' }}
                                    </button>
                                    <div class="reply-success text-green-400 mt-1 hidden text-sm">Reply saved.</div>
                                </form>
                            @else
                                <div class="text-sm text-gray-400 italic">
                                    {{ $review->reply->reply ?? 'No reply yet.' }}
                                </div>
                            @endif
                        </td>

                        <td class="py-3 px-4 border border-slate-700 text-gray-300">{{ $review->created_at->format('d M Y') }}</td>
                        <td class="py-3 px-4 border border-slate-700">
                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1.5 rounded-lg transition-colors">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 px-4 text-center text-gray-400">No reviews found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 text-gray-300">
        {{ $reviews->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.reply-form').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const reviewId = form.dataset.reviewId;
            const reply = form.querySelector('textarea[name="reply"]').value;
            const csrfToken = form.querySelector('input[name="_token"]').value;

            const response = await fetch(`/reviews/${reviewId}/reply`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ reply })
            });

            const result = await response.json();
            if (result.success) {
                const successMsg = form.querySelector('.reply-success');
                successMsg.classList.remove('hidden');
                setTimeout(() => successMsg.classList.add('hidden'), 2000);
            }
        });
    });
});
</script>
@endsection
