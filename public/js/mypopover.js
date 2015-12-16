$(document).ready(function() //once load is complete

{

    //var img = '<div id = \"image"><img src = "http://www.google.com/intl/en_ALL/images/srpr/logo11w.png" style="width:100px;" /></div>';

    $(function () {
        $('[data-toggle="popover_enrich"]').popover({container: 'body',html:'true'})  //for the enrichment popover
    });



    $(function () {
        var img = '<img src = "/images/flight-reservation-online.jpg"/>';
        $('[data-toggle="popover_ad"]').popover(
            {container: 'body',
                html:'true',
                content: img,
                placement:'bottom'
                           })  //for the ads popover
    });

	$("#enrich1").click(function(){

	$.post("/api/v1/videosignals",
    {
         username:stella.user,
		 device_id:"1",
		 video_id:stella.video_id,
		  //video_id:"1"
		 action:"3",
		 content_id:"1"
		 
        },
        function(data,status){
          //alert("Data: " + data + "\nStatus: " + status);
        });
		
		
	
	});

    $("#enrich2").click(function(){

        $.post("/api/v1/videosignals",
            {
                username:stella.user,
                device_id:"1",
                video_id:stella.video_id,
                //video_id:"1"
                action:"3",
                content_id:"2"

            },
            function(data,status){
                //alert("Data: " + data + "\nStatus: " + status);
            });
    });

        $("#ad1").click(function(){

            $.post("/api/v1/videosignals",
                {
                    username:stella.user,
                    device_id:"1",
                    video_id:stella.video_id,
                    //video_id:"1"
                    action:"4",
                    content_id:"1"

                },
                function(data,status){
                    //alert("Data: " + data + "\nStatus: " + status);
                });

        });

    $("#ad2").click(function(){

        $.post("/api/v1/videosignals",
            {
                username:stella.user,
                device_id:"1",
                video_id:stella.video_id,
                //video_id:"1"
                action:"4",
                content_id:"2"

            },
            function(data,status){
                //alert("Data: " + data + "\nStatus: " + status);
            });

    });


    $("#play").click(function(){

        $.post("/api/v1/videosignals",
            {
                username:stella.user,
                device_id:"1",
                video_id:stella.video_id,
                //video_id:"1"
                action:"1"


            },
            function(data,status){
                //alert("Data: " + data + "\nStatus: " + status);
            });

    });


    $("#stop").click(function(){

        $.post("/api/v1/videosignals",
            {
                username:stella.user,
                device_id:"1",
                video_id:stella.video_id,
                //video_id:"1"
                action:"2",
                time:"0.5",
                duration:"10"


            },
            function(data,status){
                //alert("Data: " + data + "\nStatus: " + status);
            });

    });

});

