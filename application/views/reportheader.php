<style>
  .container-fluid.nav-bg{
  background-color: #59648A;
  border-bottom: 5px solid #212B4F;
  }
  .navbar-collapse{
  padding: 0;
  }
  .navbar-nav > li > a {
  color: #ffffff;
  /*background-color: #59648A;*/
  font-size: 16px;
  font-weight: 300;
  padding-left:30px;
  }
  .navbar-nav > li > a:hover,
  .navbar-nav > li > a:focus {
  color: #ffffff;
  background-color:  #4aaaa5;
  }
  .navbar-nav > .active > a,
  .navbar-nav > .active > a:hover,
  .navbar-nav > .active > a:focus {
  color: #ffffff;
  background-color: #4aaaa5;
  }
  .navbar-nav > .open > a,
  .navbar-nav > .open > a:hover,
  .navbar-nav > .open > a:focus {
  color: #ffffff;
  background-color: #4aaaa5;
  }
  .navbar-toggle .icon-bar {
  display: block;
  width: 22px;
  height: 3px;
  background-color: #cccccc;
  }
  .dropdown-menu{
  border-radius: 0;
  }
  .hoves:hover > .dropdown-menu {
  display:block !important;
  -webkit-transition: height .5s ease;
  -webkit-transition-delay: .4s;
  }
  .dropdown-submenu{position:relative; z-index: 999;}
  .dropdown-submenu>.dropdown-menu{top:0;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;        -webkit-transition: height .5s ease;
  -webkit-transition-delay: .4s;}
  .dropdown-submenu>a:after{display:block;content:" ";float:right;width:0;height:0;border-color:transparent;border-style:solid;border-width:5px 0 5px 5px;border-left-color:#cccccc;margin-top:5px;margin-right:-10px;}
  .dropdown-submenu:hover>a:after{border-left-color:#555;}
  .dropdown-submenu.pull-left{float:none;}.dropdown-submenu.pull-left>.dropdown-menu{left:-100%;margin-left:10px;-webkit-border-radius:6px 0 6px 6px;-moz-border-radius:6px 0 6px 6px;border-radius:6px 0 6px 6px;}
  .dropdown-submenu {
  position: relative;
  }
</style>
<div class="row">
  <div class="col-lg-12">
    <nav class="navbar navbar-inverse navbar-static-top marginBottom-0" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="dropdown hoves">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Section<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?=base_url();?>report/Report/comparison_report">Section Wise Comparison Report</a></li>
              <?php if($this->session->userdata('user_id') == 1) { ?>
              <li><a href="<?=base_url();?>report/Report/machine_report">Machine & History Card Report</a></li>
              <?php } ?>
            </ul>
          </li>
          <li class="dropdown hoves">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Maintenance <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <?php if($this->session->userdata('user_id') == 1) { ?>    
              <li><a href="<?=base_url();?>report/Report/section_report">Maintenance Report</a></li>
              <?php } ?>
              <li><a href="<?=base_url();?>report/Report/breakdown_hours_report">Breakdown Hours Report</a></li>
            </ul>
          </li>
          <li class="dropdown hoves">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Store <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?=base_url();?>report/Report/currentStock">Current Stock Report</a></li>
              <li><a href="<?=base_url();?>report/Report/searchReorderLevel">Required Stock Report</a></li>
              <li><a href="<?=base_url();?>report/Report/searchBincard">Purchase Report</a></li>
              <?php if($this->session->userdata('user_id') == 1) { ?>
              <li><a href="<?=base_url();?>report/Report/spare_return">Purchase Return Report</a></li>
              <?php } ?>
            </ul>
          </li>
          <?php if($this->session->userdata('user_id') == 1) { ?>
          <li class="dropdown hoves">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Uses<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?=base_url();?>report/Report/machine_spare_report">Machine To Spare Report</a></li>
              <li><a href="<?=base_url();?>report/Report/spare_machine_report">Spare To Machine Report</a></li>
              <li><a href="<?=base_url();?>report/Report/daily_entries_report">Daily Entries Report</a></li>
            </ul>
          </li>
          <?php } ?>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
    </nav>
  </div>
</div>
<script>
  (function($){
    $(document).ready(function(){
        $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
            event.preventDefault(); 
            event.stopPropagation(); 
            $(this).parent().siblings().removeClass('open');
            $(this).parent().toggleClass('open');
        });
    });
  })(jQuery);
</script>