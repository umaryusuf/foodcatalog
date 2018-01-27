<h3>Navigation:</h3>
<ul class="sidebar">
	<li>
		<a href="myshares.php" class="<?php echo ($page === 'My Shares') ? 'highlight' : ''; ?>"><i class="fa fa-share-square"></i> My Shares</a>
	</li>
	<li>
		<a href="share_food.php" class="<?php echo ($page === 'Share Food') ? 'highlight' : ''; ?>"><i class="fa fa-share-alt"></i> Share Food</a>
	</li>
	<?php if ($page === "Edit Share"): ?>
		<li >
			<a disabled class="disabled <?php echo ($page === 'Edit Share') ? 'highlight' : ''; ?>"><i class="fa fa-edit"></i> Edit Share</a>
		</li>
	<?php endif ?>
	<li>
		<a href="profile.php" class="<?php echo ($page === 'My Profile') ? 'highlight' : ''; ?>">
			<i class="fa fa-user-o"></i> My Profile
		</a>
	</li>
	<li>
		<a href="change_password.php" class="<?php echo ($page === 'Change Password') ? 'highlight' : ''; ?>">
			<i class="fa fa-lock"></i> Change Password
		</a>
	</li>
	<li>
		<a href="logout.php" class="text-danger"><i class="fa fa-sign-out"></i> Logout</a>
	</li>
</ul>