'use strict';

window.onload = function() {

    function Article() {
        this.created = new Date();
        Article.count++;
        Article.last = this.created;
    }

    Article.count = 0;

    Article.showStats = function() {
        let total = Article.count;
        let last = Article.last;
        // console.log(`Всего: ${total}, Последняя: (${last})`);
        console.log( 'Всего: ' + this.count + ', Последняя: ' + this.last );
    };

    new Article();
    new Article();

    Article.showStats(); // Всего: 2, Последняя: (дата)

    new Article();

    Article.showStats(); // Всего: 3, Последняя: (дата)


};
