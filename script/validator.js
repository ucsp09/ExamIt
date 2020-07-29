class Validator{
    validateRegistrationForm()
    {
        var obj=new Validate();
        var list=document.querySelectorAll(":required");
        for(var i=0;i<list.length;i++)
        {
            if(obj.isEmpty(list[i]))
            {
                document.getElementById("validate").innerHTML="All Input Fields Have to be filled";
                return ;
            }
        }
        if(!obj.areEqual(list[1],list[2]))
        {
            document.getElementById("validate").innerHTML="Passwords must be same";
            return ;
        }
        document.getElementById("registrationForm").submit();
    }
    validateLoginForm()
    {
        var obj=new Validate();
        var list=document.querySelectorAll(":required");
        for(var i=0;i<list.length;i++)
        {
            if(obj.isEmpty(list[i]))
            {
                document.getElementById("validate").innerHTML="All Input Fields Have to be filled";
                return ;
            }
        }
        document.getElementById("loginForm").submit();
    }
    validateCreateForm()
    {
        var obj=new Validate();
        var list=document.querySelectorAll(":required");
        for(var i=0;i<list.length;i++)
        {
            if(obj.isEmpty(list[i]))
            {
                document.getElementById("validate").innerHTML="All Input Fields Have to be filled";
                return ;
            }
        }
        document.getElementById("createForm").submit();
    }
    validateWriteForm()
    {
        var obj=new Validate();
        var list=document.querySelectorAll(":required");
        for(var i=0;i<list.length;i++)
        {
            if(obj.isEmpty(list[i]))
            {
                document.getElementById("validate").innerHTML="All Input Fields Have to be filled";
                return ;
            }
        }
        document.getElementById("writeForm").submit();
    }
}
V=new Validator();