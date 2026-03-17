@extends('layout.app')
@section('title', 'Categories')
@section('page-title', 'Categories')
@section('page-subtitle', 'Organize your expenses')

@section('content')
    <div class="grid-2" style="margin-bottom: 2rem;">
        <!-- Add Category Form -->
        <div class="card">
            <div class="card-title" style="margin-bottom:1.25rem;">Add Category</div>
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                <div class="form-grid">
                    <div class="form-span-2">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Food, Transport, Entertainment" class="form-input">
                    </div>
                    <div class="form-span-2">
                        <label for="color" class="form-label">Color</label>
                        <div style="display:flex; gap:0.5rem; align-items:center;">
                            <input type="color" id="color" name="color" value="{{ old('color', '#3d6b4f') }}" style="width:44px; height:36px; border:1px solid var(--border); border-radius:6px; cursor:pointer; padding:2px;">
                            <input type="text" id="color_text" value="{{ old('color', '#3d6b4f') }}" class="form-input" style="flex:1;" readonly>
                        </div>
                    </div>
                    <div class="form-span-2">
                        <button type="submit" class="btn-submit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Add Category
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Category List -->
        <div class="card">
            <div class="card-title" style="margin-bottom:1rem;">Your Categories</div>
            @forelse ($categories as $category)
                <div class="expense-row">
                    <div style="width:14px; height:14px; border-radius:4px; background:{{ $category->color }}; flex-shrink:0;"></div>
                    <div class="expense-info">
                        <div class="expense-name">{{ $category->name }}</div>
                        <div style="font-size:0.72rem; color:var(--muted);">{{ $category->expenses_count }} expense{{ $category->expenses_count !== 1 ? 's' : '' }}</div>
                    </div>
                    <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Delete this category? Expenses will be uncategorized.')">
                        @csrf @method('DELETE')
                        <button type="submit" title="Delete" class="del-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        </button>
                    </form>
                </div>
            @empty
                <div class="empty-state">
                    <div style="font-size:0.95rem; font-weight:500; margin-bottom:0.35rem;">No categories yet</div>
                    <div style="font-size:0.82rem;">Create categories to organize expenses.</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('color').addEventListener('input', function() {
        document.getElementById('color_text').value = this.value;
    });
</script>
@endpush
