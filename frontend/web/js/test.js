var userAnswers = {};
var imagePathsForTest = jQuery.parseJSON(imagePathsForTest);

$("#respondent-form").submit(function( event ) {
    var results = JSON.stringify(userAnswers);
    $("#result-answers").val(results);
});

$("#startTest").on('click', function () {
    $("div .start").hide();
    $("div .test").removeClass('hidden');
});

$(document).on("click", "#answers img", function () {
    var questionNumber = $("#question").data('question');
    userAnswers[questionNumber] = $(this).data('ans');
    testOrder = jQuery.grep(testOrder, function(value) {
        return value != questionNumber;
    });

    if (testOrder.length == 0) {
        $("div .test").hide();
        $("div .inf").removeClass('hidden');
        return true;
    }

    $("#question img").attr("src", imagePathsForTest[testOrder[0]]['question']);
    $("#question").data("question", testOrder[0]);
    $("#answers img[data-ans='a']").attr("src", imagePathsForTest[testOrder[0]]['a']);
    $("#answers img[data-ans='b']").attr("src", imagePathsForTest[testOrder[0]]['b']);
    $("#answers img[data-ans='c']").attr("src", imagePathsForTest[testOrder[0]]['c']);
    $("#answers img[data-ans='d']").attr("src", imagePathsForTest[testOrder[0]]['d']);
    $("#answers img[data-ans='e']").attr("src", imagePathsForTest[testOrder[0]]['e']);
    $("#answers img[data-ans='f']").attr("src", imagePathsForTest[testOrder[0]]['f']);

    $("#pos").text((40 - testOrder.length + 1) + "/40"); // счётчик пройденых вопросов
});
