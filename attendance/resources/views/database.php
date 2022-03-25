Home | Dashboard| Events | MyCourses


Navigation
----------------------------------
-->home
->dashboard                                       ------------------------------------------
													Recent Access Courses\
												  ------------------------------------------



												  Course Overview




												  Course Information
												  -----------------------------------------
												  Course synopsis
												  Course outcome
												  Course objectives
												  delivery approach
												  mode of accessment
												  recommended reading list
												  Announcements
												  Self Introduction


												  Week 1
												  ---------------
												  introduction
												  learning objectives
												  lecture slid
												  video url

												  outcomes
												  Lead Facilitator

												  Announcements

->My course


Private Files
-----------------------------------


Online Users
----------------------------------



Calenda
-----------------------------------



Upcoming Events
-----------------------------------








https://youtu.be/hN5RInFEwGM
https://youtu.be/4DLALW2VyHA

<iframe width="560" height="315"
src="https://www.youtube.com/embed/hN5RInFEwGM"
frameborder="0" allow="accelerometer; autoplay;
clipboard-write; encrypted-media; gyroscope;
picture-in-picture" allowfullscreen>
</iframe>
https://codepen.io/Middi/pen/QQrOdBz

https://penguin-arts.com/how-to-implement-youtube-playlist-player-with-jquery/

//youtube views
<?php
$video_ID = 'your-video-ID';
$JSON = file_get_contents("https://gdata.youtube.com/feeds/api/videos/{$video_ID}?v=2&alt=json");
$JSON_Data = json_decode($JSON);
$views = $JSON_Data->{'entry'}->{'yt$statistics'}->{'viewCount'};
echo $views;
?>



<?php
  $yt_api = 'YOUTUBE_DATA_API_KEY';
  $channelId = 'YOUTUBE_CHANNEL_ID';
  $yt_api_url = 'https://www.googleapis.com/youtube/v3/search?key=' . $yt_api;
   $yt_json = file_get_contents($yt_api_url);
?>









//forum

https://forum.freecodecamp.org/