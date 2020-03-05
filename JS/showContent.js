$(function () {

    console.log('Привет, это страый js ))');
    init_get();
    init_post();
    init_post_new();
    init_get_new();
});

function init_get() {
    $('a.ajaxArticleBodyByGet').one('click', function () {
        var contentId = $(this).attr('data-contentId');
        console.log('ID статьи = ', contentId);
        showLoaderIdentity();
        $.ajax({
            method: "GET",
            url: '/ajax/showContentsHandler.php',
            data: {'articleId': contentId}
        })
            .done(function (obj) {
                hideLoaderIdentity();
                console.log('Ответ получен');
                $('li.article' + contentId).append(obj);
            })
            .fail(function (xhr, status, error) {
                hideLoaderIdentity();

                console.log('ajaxError xhr:', xhr); // выводим значения переменных
                console.log('ajaxError status:', status);
                console.log('ajaxError error:', error);

                console.log('Ошибка соединения при получении данных (GET)');
            });

        return false;

    });
}

function init_post() {
    $('a.ajaxArticleBodyByPost').one('click', function () {
        var content = $(this).attr('data-contentId');
        console.log('ID статьи = ', content);
        showLoaderIdentity();
        $.ajax({
            method: 'POST',
            url: '/ajax/showContentsHandler.php',
            dataType: 'json',
            data: {'articleId': content}
        })
            .done(function (obj) {
                hideLoaderIdentity();
                console.log('Ответ получен');
                $('li.article' + content).append(obj);
            })
            .fail(function (xhr, status, error) {
                hideLoaderIdentity();
                console.log('Ошибка соединения с сервером (POST)');
                console.log('ajaxError xhr:', xhr); // выводим значения переменных
                console.log('ajaxError status:', status);
                console.log('ajaxError error:', error);
            });

        return false;

    });
}

function  addClicked (elem) {
    elem.classList.add('clicked');
}

const URL = '/ajax/showContentsHandler.php';

function init_post_new() {
    let target = 'ajaxNewPost';
    document.addEventListener('click', function (evt) {
        if (evt.target.classList.contains(target)  && !evt.target.classList.contains('clicked')) {
            evt.preventDefault();
            let articleId = evt.target.dataset.articleId;
            addClicked(evt.target);
            const xhr = new XMLHttpRequest();
            xhr.onload = function () {
                console.log(xhr.status);
                const serverResponse = document.querySelector(`.article${articleId}`);
                serverResponse.innerHTML += this.response;
            };
            xhr.responseType = 'json';
            xhr.open('POST', URL);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(`articleId=${encodeURIComponent(articleId)}`);
        }
    })

}

function init_get_new() {
    let target = 'ajaxNewGet';
    document.addEventListener('click', function (evt) {
        if (evt.target.classList.contains(target) && !evt.target.classList.contains('clicked')) {
            evt.preventDefault();
            let articleId = evt.target.dataset.articleId;
            let params = `articleId=${encodeURIComponent(articleId)}`;
            addClicked(evt.target);
            const xhr = new XMLHttpRequest();
            xhr.onload = function () {
                console.log(xhr.status);
                const serverResponse = document.querySelector(`.article${articleId}`);
                serverResponse.innerHTML += this.response;
            };
            xhr.open('GET', `${URL}?${params}`);
            xhr.send();
        }
    })

}
