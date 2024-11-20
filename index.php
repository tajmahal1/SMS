<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Osiris</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="./css/style.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
    <script src="https://kit.fontawesome.com/2e63b57e77.js" crossorigin="anonymous"></script>
    
    <link rel="icon" type="image/png" sizes="16x16" href="img/header.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/header.png">

<style>

    #sendBut:active, #sendBut:focus {
        outline: none;
    }
    
    h4 {
    font-family: "BPG Algeti", sans-serif;
    }

</style>
</head>
<body>
<!-- partial:index.partial.html -->
<div class="container">
    <br>
    <a href="#">
        <img src="img/header.png" height="100px" class="ml-10">
             </a>
    <h1></h1>
    <a href="#" class="btn btn-primary">მთავარი</a>
    <a target="_blank" href="#" class="btn btn-warning">გაგზავნილი შეტყობინებები</a>
    <hr>


        <div class="form-group">
            <label for="name">გამგზავნის დასახელება</label>
            <input type="text" class="form-control" id="name" placeholder="სასურველი სათაური"/>
        </div>
        

        <div class="form-group">
            <label for="mobile">ადრესატის ტელ.ნომერი</label>
            <input type="text" class="form-control" id="mobile" pattern="\d*" maxlength="9" placeholder="555102030"/>
        </div>
        
        
        <div class="form-group">
            <label for="txt">შეტყობინება</label>
            <textarea id="txt" class="form-control" rows="3" maxlength="70" placeholder="მაქსიმუმ 70 სიმბოლო"></textarea>
            <p style="font-size:16px;color:#333333" class="help-block">სიმბოლო: <b class="counter">0</b>/70</p>
            <script>
                var textarea = document.getElementById("txt"),
                counter = document.querySelector(".counter");
                textarea.addEventListener("keyup", function() {
                    counter.innerHTML = this.value.length;
                }, false);
            </script>
        </div>

        <button id="sendBut" type="button" class="btn btn-default" style="font-size: 15px;">შეტყობინების გაგზავნა</button>
        <div class="alert alert-warning" id="sendAlert" role="alert" style="display: none; margin-top: 20px"></div>

        <hr>
                 
        <div class="section">
            <div class="alert alert-danger">
            <div class="alert-body">
            <i class="ls ls-lock"></i>
            პროცესი ხორციელდება დაცულ გარემოში, რომლის დროსაც თქვენი აიპით განხორციელებული ქმედებები ინახება: IP - <span class="ip" </span> 
                </div>
            </div>    
        </div>


        </div>
        <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>

        <script type="text/javascript">
            $(document).ready(function() {
            $.getJSON("https://api.ipify.org/?format=json", function(e) {
            $('.ip').text(e.ip);
                });
                });
            </script>


        <script>
    $(document).ready(function(){
        setInputFilter(document.getElementById("mobile"), function(value) {
            return /^\d*\d*$/.test(value); 
        });
    })
    
    $("#sendBut").click(function(){
        
        var senderName  = $("#name").val();
        var sendTo      = $("#mobile").val();
        var senderText  = $("#txt").val();
        
        if(senderName != '' && sendTo != '' && senderText != '') {

            $("#sendAlert").fadeOut();

            $.ajax({
                url: "send.php",
                dataType: "json",
                type: "POST",
                data: {
                    act: "send",
                    name: senderName,
                    to: sendTo,
                    text: senderText
                },
                beforeSend: () => {
                    $("#sendBut").prop("disabled", true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>იგზავნება...');
                },
                success: (data) => {
                    $("#sendBut").prop("disabled", false).html('შეტყობინების გაგზავნა');

                    $("#sendAlert").removeClass("alert-warning").addClass("alert-success").fadeIn().html("შეტყობინება წარმატებით გაიგზავნა");

                    setTimeout(() => {
                        $("#sendAlert").fadeOut()
                    }, 2000)
                    
                }
            })
        }else{

            $("#sendAlert").fadeIn().html("შეავსეთ ყველა ველი!");

        }
    })


function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
        textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
            this.value = "";
        }
        });
    });
}

</script>
        

</body>
</html>
