<div class="categories">
    <h2>Categories</h2>
    <form id="categoryForm" method="POST" action="/category/create">
        @csrf
        <div>
            <label for="name">New Category Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <input type="hidden" name="article_id" value="{{ $article->id }}">
        <button type="submit">Create Category</button>
    </form>

    <div id="categoryMessage" class="message"></div>
    <div id="attachCategoryMessage" class="message" ></div>

        <form id="attachCategoryForm" method="POST" action="/category/attach">
        @csrf
        <input type="hidden" name="article_id" value="{{ $article->id }}">
        <input type="hidden" name="category_id" id="attach_category_id">
            @foreach($availableCategories as $category)
                <button type="button" class="attach-category-button" data-id="{{ $category->id }}">{{ $category->name }}</button>
            @endforeach
        </form>

    
</div>

<!-- Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- AJAX Script -->
<script>
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    axios.post(this.action, formData)
        .then(function(response) {

            document.getElementById('categoryMessage').innerText = response.data.message;


            let attachForm = document.getElementById('attachCategoryForm');
            let button = document.createElement('button');
            button.type = 'button';
            button.classList.add('attach-category-button');
            button.dataset.id = response.data.category.id;
            button.textContent = response.data.category.name;


            button.addEventListener('click', function() {
                document.getElementById('attach_category_id').value = this.dataset.id;
                let formData = new FormData(attachForm);
                axios.post(attachForm.action, formData)
                    .then(resp => {
                        document.getElementById('attachCategoryMessage').innerText = resp.data.message;
                        this.classList.add('attached');
                    })
                    .catch(err => {
                        console.error(err);
                        document.getElementById('attachCategoryMessage').innerText = 'Error attaching category.';
                    });
            });

            attachForm.appendChild(button);


            document.getElementById('categoryForm').reset();
        })
        .catch(function(error) {
            console.error(error);
            document.getElementById('categoryMessage').innerText = 'Error creating category.';
        });
});


document.querySelectorAll('.attach-category-button').forEach(button => {
    button.addEventListener('click', function() {

        document.getElementById('attach_category_id').value = this.dataset.id;


        let formData = new FormData(document.getElementById('attachCategoryForm'));


        axios.post(document.getElementById('attachCategoryForm').action, formData)
            .then(response => {
                document.getElementById('attachCategoryMessage').innerText = response.data.message;


                document.getElementById('usedCategoriesContainer').appendChild(this);
            })
            .catch(error => {
                console.error(error);
                document.getElementById('attachCategoryMessage').innerText = 'Error attaching category.';
            });
    });
});

</script>
