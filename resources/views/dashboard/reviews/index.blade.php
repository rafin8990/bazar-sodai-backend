@extends('dashboard.app')

@section('title', 'All Reviews')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">All Product Reviews</h1>

    @include('Alert.alert')

    <table class="min-w-full bg-white border rounded-lg shadow">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="py-3 px-4">#</th>
                <th class="py-3 px-4">User</th>
                <th class="py-3 px-4">Product</th>
                <th class="py-3 px-4">Review</th>
                <th class="py-3 px-4">Reply</th>
                <th class="py-3 px-4">Date</th>
                <th class="py-3 px-4">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reviews as $index => $review)
                <tr class="border-t hover:bg-gray-50">
                    <td class="py-2 px-4">{{ $reviews->firstItem() + $index }}</td>
                    <td class="py-2 px-4">{{ $review->user->name }}</td>
                    <td class="py-2 px-4">{{ $review->product->name }}</td>
                    <td class="py-2 px-4">{{ $review->review_details }}</td>

                    <td class="py-2 px-4">
                        @if(auth()->user()->role === 'admin')
                            <form class="reply-form" data-review-id="{{ $review->id }}">
                                @csrf
                                <textarea name="reply" class="border p-2 w-full rounded mb-2" rows="2" placeholder="Write a reply...">{{ $review->reply->reply ?? '' }}</textarea>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                    {{ $review->reply ? 'Update Reply' : 'Send Reply' }}
                                </button>
                                <div class="reply-success text-green-600 mt-1 hidden">Reply saved.</div>
                            </form>
                        @else
                            <div class="text-sm text-gray-600 italic">
                                {{ $review->reply->reply ?? 'No reply yet.' }}
                            </div>
                        @endif
                    </td>

                    <td class="py-2 px-4">{{ $review->created_at->format('d M Y') }}</td>
                    <td class="py-2 px-4">
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1 rounded">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="py-4 px-4 text-center text-gray-500">No reviews found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-6">
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
