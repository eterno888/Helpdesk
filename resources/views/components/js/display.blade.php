<script>
    var display = false;
    function onDisplayPressed(){
        if( ! display) {
            return startDisplay();
        }
        display();
    }

    function startDisplay(){
        display = true;
        $("#displayButton").removeClass("secondary");
        $("#displayButton").html("Выберите новости для отображения и нажмите сюда");
        $(".selector").show();
    }

    function getSelectedNewsIds(){
        return $("input[name^=selected]:checked").map(function() {
            return $(this).attr("meta:index");
        }).toArray();
    }

    function display(){
        var news = getSelectedNewsIds();
        if(news.length == 0) return;

        $.post({
            url: "{{ route('news.display.store') }}",
            data: {
                "news_id" : news,
            },
            success: function(){
                location.reload();
            }
        });
    }
</script>