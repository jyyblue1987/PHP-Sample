@extends('layout')
@section('content')

<div id="main_column" class="clear">
   <div>                
		<div class="clear mainbox-title-container">
				<h1 class="mainbox-title float-left">
					Users 
				</h1>
		</div>
		<div id="search-form" class="section-border">
			<form name="user_search_form" action="/index.php/search" method="GET" class="">
				<table cellpadding="0" cellspacing="0" border="0" class="search-header">
					<tr>
						<td style="display:none">
							<input type="hidden" name="r" value="user/admin">
						</td>
						<td class="search-field nowrap">
							<label for="elm_name"></label>
							<div class="break">
								<input class="input-text" type="text" size="15" name="name" id="name" value=""/>
							</div>
						</td>
						<td class="buttons-container">
							<span  class="submit-button ">
								<input type="submit" name="mode" value="Search" />
							</span>
						</td>
					</tr>
				</table>
			</form>
		</div>

		<div class="mainbox-body" >
			<div id="content_manage_users">
				<form action="/index.php/users" method="GET">
					<div id="data_grid_view" class="grid-view">
					<div class="summary">
					<?php 
						$start = ($users->getCurrentPage() - 1) * $users->getPerPage() + 1; 
						$end = $start + $users->count() - 1 
					?>
					{{'Displaying ' .  $start . '-' . $end . ' of ' . $users->getTotal() . ' results.'}}
					</div>
					<table class="items">
						<thead>
							<tr>
								<th id="data_grid_view_c1"><a class="sort-link" href="/index.php?r=user/admin&amp;User_sort=name">No</a></th>
								<th id="data_grid_view_c1"><a class="sort-link" href="/index.php?r=user/admin&amp;User_sort=name">Mobile</a></th>
								<th id="data_grid_view_c2"><a class="sort-link" href="/index.php?r=user/admin&amp;User_sort=mobile">Name</a></th>
								<th id="data_grid_view_c3"><a class="sort-link" href="/index.php?r=user/admin&amp;User_sort=email">Email</a></th>
								<th id="data_grid_view_c7"><a class="sort-link" href="/index.php?r=user/admin&amp;User_sort=status">Status</a></th>
								<th class="button-column" id="data_grid_view_c8">
									<select onchange="this.form.submit()"  name="pageSize" id="pageSize">
										<?php 
											switch ($item_v) {
												case 10:
													echo "<option selected value='10'>10</option>"."\n";
													echo "<option value='20'>20</option>"."\n";
													echo "<option value='50'>50</option>"."\n";
													echo "<option value='100'>100</option>"."\n";
													break;
												case 20:
													echo "<option value='10'>10</option>"."\n";
													echo "<option selected value='20'>20</option>"."\n";
													echo "<option value='50'>50</option>"."\n";
													echo "<option value='100'>100</option>"."\n";
													break;
												case 50:
													echo "<option value='10'>10</option>"."\n";
													echo "<option value='20'>20</option>"."\n";
													echo "<option selected value='50'>50</option>"."\n";
													echo "<option value='100'>100</option>"."\n";
													break;
												default:
													echo "<option selected value='10'>10</option>"."\n";
													echo "<option value='20'>20</option>"."\n";
													echo "<option value='50'>50</option>"."\n";
													echo "<option value='100'>100</option>"."\n";
													break;
											}
										?>	
										
									</select>
								</th>
							</tr>
						</thead>	
						<tbody>
							<?php
								$i = 1;
								foreach( $users as $value )	
								{
									
									echo '<tr class="odd">';
									echo '<td>'.$i.'</td>';
									echo '<td width="10%"><a class="view" href="/index.php/userprofile?pname='.$value['username'].'">'.$value['mobile'].'</td>
										<td><a class="view" href="/index.php/userprofile?pname='.$value['username'].'">'.$value['name'].'</a></td>';
									
									echo '<td>'.$value['email'].'</td>';
									$user = getUser($value['username']);
									$userinfo = json_decode($user['result'], true);
									if($userinfo['state'] = 'offline')
									{
									//echo '<td>'.$userinfo['state'].'</td>';
										echo '<td width="8%">&nbsp;&nbsp;&nbsp;&nbsp;<a class="view" title="View user profile" href="/index.php?r=user/view&amp;id=1"><img src="/images/customers.png" alt="View user profile" /></a></td>';									
									}
									else
									{
										echo '<td width="8%">&nbsp;&nbsp;&nbsp;&nbsp;<a class="view" title="View user profile" href="/index.php?r=user/view&amp;id=1"><img src="/images/customers.png" alt="View user profile" /></a></td>';
									}
									echo '<td width="8%">&nbsp;&nbsp;&nbsp;&nbsp;<a class="view" title="View user profile" href="/index.php/userprofile?pname='.$value['username'].'"><img src="/images/customers.png" alt="View user profile" /></a></td></tr>';
									//echo '<td width="8%"><input src="/index.php/userprofile'"><img src="/images/customers.png" alt="View user profile" /></td></tr>';
									$i++;
								}

							?>

						</tbody>
					</table>
					<div class="pager">
						Go to page
						<ul class="yiiPager">
							<?php echo with(new ZurbPresenter($users))->render(); ?>						
						</ul>
					</div>
				</form>
			</div>
		</div>
@stop
