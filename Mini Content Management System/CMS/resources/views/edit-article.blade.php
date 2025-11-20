@extends('layouts.article-crud')

@section('content')

<form id="articleForm" method="POST" action="/article/edit/{{ $article->id }}">
    @csrf
    @method('PUT')
    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="{{ $article->title }}" required>
    </div>
    <div>
        <label for="teaser">Teaser:</label>
        <input type="text" id="teaser" name="teaser" value="{{ $article->teaser }}" required>
    </div>
    <div>
        <label for="body">Body:</label>
        <textarea id="body" name="body" required>{{ $article->body }}</textarea>
    </div>

    <button type="submit" id="saveButton">Save Changes</button>
</form>

<hr>

<div class="categories">
    <h3>Attached Categories</h3>

    <div id="usedCategoriesContainer">
        @foreach($usedCategories as $category)
            <button type="button"
                    class="used-category-button"
                    data-id="{{ $category->id }}">
                {{ $category->name }}
            </button>
        @endforeach
    </div>

    <div id="detachCategoryMessage" class="message"></div>
</div>


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
const tokenMeta = document.querySelector('meta[name="csrf-token"]');
if (tokenMeta) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = tokenMeta.getAttribute('content');
}


const detachMessageEl = document.getElementById('detachCategoryMessage');
const usedContainer = document.getElementById('usedCategoriesContainer');
const articleId = '{{ $article->id }}'; 
const detachUrl = '/category/detach';   


usedContainer.addEventListener('click', function(e) {
    const btn = e.target;
    if (!btn.classList.contains('used-category-button')) return;

    const categoryId = btn.dataset.id;

    if (!confirm('Remove category "' + btn.textContent.trim() + '" from this article?')) {
        return;
    }


    axios.delete(detachUrl, {
        data: {
            article_id: articleId,
            category_id: categoryId
        }
    })
    .then(response => {
        detachMessageEl.innerText = response.data.message || 'Category removed';
        btn.classList.remove('used-category-button');
        btn.classList.add('attach-category-button');

        document.getElementById('attachCategoryForm').appendChild(btn);

    })
    .catch(error => {
        console.error(error);
        if (error.response && error.response.status === 422) {

            const errs = error.response.data.errors;
            detachMessageEl.innerText = Object.values(errs).flat().join(' ');
        } else {
            detachMessageEl.innerText = (error.response?.data?.message) || 'Error detaching category.';
        }
    });
});
</script>

@endsection
