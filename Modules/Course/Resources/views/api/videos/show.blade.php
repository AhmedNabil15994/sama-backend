<html>
<head>
  <style>
    body {
      background-color: black;
      margin: 0px;
    }
  </style>
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0">
  <meta http-equiv="Content-Security-Policy"
        content="default-src * gap:; script-src * 'unsafe-inline' 'unsafe-eval'; connect-src *;
                img-src * data: blob: android-webview-video-poster:; style-src * 'unsafe-inline';">
</head>
<body>
<iframe
  src="{{$videoUrl}}"
  width="100%" height="100%" frameborder="0" allow="fullscreen"
  allowfullscreen></iframe>

</body>
{{--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>--}}
{{--<script src="https://player.vimeo.com/api/player.js"></script>--}}
{{--<script>--}}
{{--  var iframe = document.querySelector('iframe');--}}
{{--  var options = {--}}
{{--    fullscreen: true,--}}
{{--    playsinline: true,--}}
{{--  };--}}

{{--  var player = new Vimeo.Player(iframe, options);--}}
{{--  var video_duration = 0;--}}
{{--  player.getDuration().then(function (duration) {--}}
{{--    // duration = the duration of the video in seconds--}}
{{--    video_duration = duration;--}}
{{--  }).catch(function (error) {--}}
{{--    // an error occurred--}}
{{--  });--}}

{{--  var currentTime = '{{$user_video ? $user_video->totalPlayed : 0}}'--}}
{{--  player.setCurrentTime(currentTime).then(function(seconds) {--}}
{{--    // `seconds` indicates the actual time that the player seeks to--}}
{{--  }).catch(function(error) {--}}

{{--  });--}}

{{--  var lesson_content_id = '{{$lesson_content ? $lesson_content->id : ""}}';--}}
{{--  var user_id = '{{$user_id}}';--}}

{{--  var onPlay = function (data) {--}}
{{--    if (lesson_content_id !== "") {--}}
{{--      handeLessonContentView(data.seconds, data.percent, data.duration, lesson_content_id, user_id)--}}
{{--    }--}}
{{--  };--}}
{{--  player.on('timeupdate', onPlay);--}}


{{--  function handeLessonContentView(totalPlayed, percent, video_duration, lesson_content_id, user_id) {--}}
{{--    $.ajax({--}}
{{--      type: "get",--}}
{{--      url: "{{ route('api.course.make.view') }}",--}}
{{--      data: {totalPlayed, percent, video_duration, lesson_content_id, user_id},--}}
{{--      dataType: "json",--}}
{{--      success: function (response) {--}}
{{--      }--}}

{{--    });--}}
{{--  }--}}
{{--</script>--}}

</html>
