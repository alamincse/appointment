<div class="wrap">
	<h1 class="wp-heading-inline">Edit Doctor</h1>
    <form action="" method="POST">
    	<table>
    		<tr>
    			<th><label for="name">Name</label></th>
    			<td><input type="text" id="name" name="dr_name" value="<?php echo esc_attr( $doctor->name ); ?>" required></td>
    		</tr>
            <tr>
                <th><label for="degree">Degree</label></th>
                <td><input type="text" id="degree" name="dr_degree" value="<?php echo esc_attr( $doctor->degree ); ?>" required></td>
            </tr>
    		<tr>
    			<th><label for="email">Email</label></th>
    			<td><input type="text" id="email" name="dr_email" value="<?php echo esc_attr( $doctor->email ); ?>" required></td>
    		</tr>
    		<tr>
    			<th><label for="phone">Phone</label></th>
    			<td><input type="text" id="phone" name="dr_phone" value="<?php echo esc_attr( $doctor->phone ); ?>" required></td>
    		</tr>
    		<tr>
                <th><label for="fee">Dr. Fee</label></th>
                <td><input type="number" id="fee" name="dr_fee" value="<?php echo esc_attr( $doctor->fee ); ?>" required></td>
            </tr>
    		<tr>
    			<td><input type="hidden" name="id" value="<?php echo esc_attr( $doctor->id ); ?>"></td>
    		</tr>
    		<tr>
    			<td><?php wp_nonce_field( 'update-doctor' ); ?></td>
    		</tr>
	    	<tr>
    			<th><label for="submit"></label></th>
    			<td><input type="submit" name="update_doctor" value="Update"></td>
    		</tr>
    	</table>
    </form>
</div>