	<ul>
		<li>
			<input type="text" id="name" name="name" title="Enter your Full Name" placeholder="Full Name" value="<?php echo $_POST['name']?>" autofocus onchange="jsname()" style="text-transform:capitalize" pattern="^[A-Za-z][A-Za-z. ]+$" required/>
			<span class="error" id="err-name"><?php echo $err['name']; ?></span>
		</li>
		<li>
			<input id="email" type="email" name="email" title="Enter your email address" placeholder="Email Address" value="<?php echo $_POST['email']?>" onchange="jsemail()" required/>
			<span class="error" id="err-email"><?php echo $err['email']; ?></span>
		</li>
		<li>
			<input id="password" type="password" name="password" title="Minimum 5 char long" placeholder="Password" value="<?php echo $_POST['password']?>" onchange="jspassword()" maxlength="20" pattern="^.{5,20}$" required />
			<span class="error" id="err-password"><?php echo $err['password']; ?></span>
		</li>
<!--No mobile numbers collected
		<li>
			<input id="mobile" type="tel" name="mobile" maxlength="10" title="Enter your 10-digit mobile number" placeholder="Mobile Number" onchange="jsmobile()" pattern="^[789]\d{9}$" required/>
			<span class="error" id="err-mobile"><?php echo $err['mobile']; ?></span>
		</li>
		-->
	</ul>
	
	<!-- <?php echo $_POST['name']?> -->