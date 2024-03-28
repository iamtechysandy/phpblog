function createTag() {
    var newTagName = document.getElementById('newTag').value.trim();
    if (newTagName === '') {
        alert('Please enter a tag name.');
        return;
    }
    
    // AJAX request to create the new tag
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'create_tag.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var tagId = xhr.responseText;
            var tagName = newTagName;
            var option = new Option(tagName, tagId);
            document.getElementById('tags').appendChild(option);
            alert('Tag created successfully!');
        } else {
            alert('Error creating tag: ' + xhr.responseText);
        }
    };
    xhr.send('tagName=' + encodeURIComponent(newTagName));
}

function createCategory() {
    var newCategoryName = document.getElementById('newCategory').value.trim();
    if (newCategoryName === '') {
        alert('Please enter a category name.');
        return;
    }
    
    // AJAX request to create the new category
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'create_category.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var categoryId = xhr.responseText;
            var categoryName = newCategoryName;
            var option = new Option(categoryName, categoryId);
            document.getElementById('categories').appendChild(option);
            alert('Category created successfully!');
        } else {
            alert('Error creating category: ' + xhr.responseText);
        }
    };
    xhr.send('categoryName=' + encodeURIComponent(newCategoryName));
}

// Additional JavaScript code for form submission, AJAX file upload, etc. can be added here
