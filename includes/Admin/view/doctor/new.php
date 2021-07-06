<div class="wrap">
	<h2 class="wp-heading-inline">New Doctor</h2>
    <form action="" method="POST">
    	<table>
    		<tr>
    			<th><label for="name">Name</label></th>
    			<td><input type="text" id="name" name="dr_name" required></td>
    		</tr>
    		<tr>
    			<th><label for="degree">Degree</label></th>
    			<td><input type="text" id="degree" name="dr_degree" required></td>
    		</tr>
    		<tr>
    			<th><label for="email">Email</label></th>
    			<td><input type="text" id="email" name="dr_email" required></td>
    		</tr>
    		<tr>
    			<th><label for="phone">Phone</label></th>
    			<td><input type="text" id="phone" name="dr_phone" required></td>
    		</tr>
    		<tr>
    			<th><label for="fee">Dr. Fee</label></th>
    			<td><input type="number" id="fee" name="dr_fee" required></td>
    		</tr>
    		<tr>
    			<td><?php wp_nonce_field( 'new-doctor' ); ?></td>
    		</tr>
	    	<tr>
    			<th><label></label></th>
    			<td><input type="submit" name="submit_doctor" value="Save Doctor"></td>
    		</tr>
    	</table>
    </form>
</div>