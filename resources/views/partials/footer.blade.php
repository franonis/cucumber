<footer>
      <div class="row">
        <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
         <div class="col-xs-12">
          <h4>Contact Us</h4>
           <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 contact">
            <p>Institute of Vegetables and Flowers<br>
               Chinese Academy of Agricultural Scicences, Beijing<br>
               <span class="fui-mail"></span>   E-mail: <a href="mailto:huangsanwen@caas.net.cn" style="word-wrap:break-word">huangsanwen@caas.net.cn</a>
            </p>
           </div>
           <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 contact">
            <p style="word-wrap:break-word">Laboratory of Computational Molecular Biology<br>
             College of Life Sciences, Beijing Normal university<br>
             <span class="fui-mail"></span>   E-mail: <a href="mailto:linkui@bnu.edu.cn">linkui@bnu.edu.cn</a>
            </p>
           </div>            
          </div> <!-- /col-xs-6 -->
         </div>
         <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
          <h4>Links</h4>           
           <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
            <p><a href="http://solgenomics.net/" target="_blank"><img src="{{ asset('image/sgn_logo_icon.png') }}" width="40px"> SOL Genomics Network (SGN)</a></p>
            <p><a href="http://blast.st-va.ncbi.nlm.nih.gov/Blast.cgi" target="_blank"><img src="{{ asset('image/ncbi.jpg') }}" width="60px"> Basic Local Alignment Search Tool (BLAST)</a></p>                    
           </div>
           <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
            <p><a href="http://gmod.org/wiki/Gbrowse" target="_blank"><img src="{{ asset('image/gbrowse.jpg') }}" width="40px"> Generic Genome Browser (GBrowse)</a></p>
            <p><a href="http://www.ncbi.nlm.nih.gov/" target="_blank"><img src="{{ asset('image/ncbi.jpg') }}" width="60px"> The National Center for Biotechnology Information </a></p>
           </div>
         </div>
        <h6 class="text-center">Copyright &copy; 2013-{{ date('Y') }} <a href="mailto:{{ config('app.admin_email') }}" data-toggle="tooltip" data-placement="top" title="Send e-mail to the web administrator">Cucurbitaceous Germplasm Resources</a> All Rights Reserved.</h6>
      </div>
      </footer>
      <script>$(document).ready(function(){$("#back-to-top").hide();$(function (){$(window).scroll(function(){if ($(window).scrollTop()>400){$("#back-to-top").fadeIn(500);}else{$("#back-to-top").fadeOut(1500);}});$("#back-to-top").click(function(){$('body,html').animate({scrollTop:0},1000);return false;});});});$("#narbar-search-btn").popover();$('.navbar-nav .dropdown').mouseover(function(){$(this).addClass('open');});$('.navbar-nav .dropdown').mouseout(function(){$(this).removeClass('open');});$('[data-toggle="tooltip"]').tooltip();$('nav').autoHidingNavbar();</script>
      <div id="back-to-top"><a href="#top"><span class="glyphicon glyphicon-chevron-up"></span></a></div>