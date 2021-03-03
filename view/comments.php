<div class="container">

    <h3 class="text-center">What people thinks about us:</h3>

    <div class="comments-container" id="usersComments">
        <?php foreach ($comments as $value) : ?>
            <div class="card m-3 mx-auto">
                <h5 class="card-header"><?php echo $value->author; ?></h5>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $value->comment_body; ?></h5>
                    <p class="card-text"><?php echo $value->created_at; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (!\app\core\Session::isUserLoggedIn()) : ?>
        <p class="text-center">If you want to leave comment - please <a href="/login">login</a>. </p>
    <?php else : ?>

        <form id="add-comment-form" action="" method="post">
            <div class="form-group">
                <textarea id="comment-body" name="commentBody" class="form-control" placeholder="Add comment"></textarea>
                <span class='invalid-feedback'></span>
            </div>
            <button id='submit-btn' type="submit" class='btn btn-dark'>Comment</button>
        </form>

    <?php endif; ?>
</div>


<script>
    const addCommentFormEl = document.getElementById('add-comment-form');
    const commentsCont = document.getElementById('usersComments');
    const textarea = document.getElementById('comment-body');

    if (addCommentFormEl) {
        addCommentFormEl.addEventListener('submit', addCommentAsync);
    }


    function addCommentAsync(event) {
        event.preventDefault();

        // add data and post it to api 
        const addCommentFormData = new FormData(addCommentFormEl);

        // send data to api 
        fetch('/api', {
                method: 'post',
                body: addCommentFormData
            })
            .then(resp => resp.json())
            .then(data => {
                if (data.success) {
                    renderComments(data.comments);
                } else {
                    errorsHandler(data.error)
                }
            })
            .catch(error => console.error(error));
    }

    function renderComments(commentsObj) {
        usersComments.innerHTML = '';
        textarea.classList.remove('is-invalid')

        commentsObj.forEach(function(comment) {
            usersComments.innerHTML += commentSorter(comment)
        });
    }

    function commentSorter(arg) {

        textarea.value = '';

        return ` 
        <div class="card m-3 mx-auto">
            <h5 class="card-header">${arg.author}</h5>
            <div class="card-body">
                <h5 class="card-title">${arg.comment_body}</h5>
                <p class="card-text">${arg.created_at}</p>
            </div>
        </div>`
    }

    function errorsHandler(error) {
        textarea.classList.add('is-invalid');
        textarea.nextElementSibling.innerHTML = error;
    }

    const comments = document.getElementById('comments')
    comments.classList.add('active')
</script>