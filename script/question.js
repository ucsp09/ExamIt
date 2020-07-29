class Question{
    constructor()    
    {
        this._node=document.createElement('div');
        this._node.className="question";
    }
    get node()
    {
        return this._node;
    }
}
class TextBox extends Question{
    constructor()
    {
        super();
        this._node.innerHTML="<div class=\"question_content\">"
        +"<input class=\"texts\" name=\"question[]\" value=\"Untitled Question\" required>"
        +"<input type=\"button\" class=\"buttons\" value=\"Remove Question\" onclick=\"S.removeQuestion(event)\">"
        +"</div>"
        +"<div class=\"option\">"
        +"<input class=\"texts\" type=\"text\" name=\"option[]\" value=\"Type Your Answer Here\" disabled/>"
        +"</div>";
    }
}