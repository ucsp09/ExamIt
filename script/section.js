class Section{
    constructor()
    {
        this.numQuestions=1;
    }
    addQuestion()
    {
        var newTextBox=new TextBox();
        document.getElementById("root").appendChild(newTextBox.node);
        this.numQuestions++;
    }
    removeQuestion(event)
    {
        if(this.numQuestions!=1)
        {
            var Question=event.target.parentNode.parentNode;
            document.getElementById("root").removeChild(Question);
            this.numQuestions--;
        }
    }
}
S=new Section();