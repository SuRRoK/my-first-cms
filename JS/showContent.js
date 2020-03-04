$(function () {

    console.log('Привет, это страый js ))');
    init_get();
    init_post();
});

function init_get() {
    $('a.ajaxArticleBodyByGet').one('click', function () {
        var contentId = $(this).attr('data-contentId');
        console.log('ID статьи = ', contentId);
        showLoaderIdentity();
        $.ajax({
            method: "GET",
            url: '/ajax/showContentsHandler.php',
            dataType: 'json',
            data: {'articleId': contentId}
        })
            .done(function (obj) {
                hideLoaderIdentity();
                console.log('Ответ получен');
                $('li.' + contentId).append(obj);
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
                console.log('Ответ получен', obj);
                $('li.' + content).append(obj);
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

/*function init_post() {

    let a = document.querySelector('.ajaxArticleBodyByPost');
    a.addEventListener('click', function (evt) {
        evt.preventDefault();
        var contentId = $(this).attr('data-contentId');
        console.log(contentId);
        console.log('hello');
    })

}*/
