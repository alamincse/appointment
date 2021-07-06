<div class="wrap">
	<h2 class="wp-heading-inline">New Patient</h2>
    <form action="" method="POST">
    	<table>
            <tr>
                <th><label for="patient_name">Name</label></th>
                <td><input type="text" id="patient_name" name="patient_name" required></td>
            </tr>

            <tr>
                <th><label for="phone">Phone</label></th>
                <td><input type="text" id="phone" name="phone" required></td>
            </tr>
            <tr>
                <th><label for="email">Email</label></th>
                <td><input type="email" id="email" name="email" required></td>
            </tr>

            <tr>
                <th><label for="desc">Address</label></th>
                <td><textarea rows="5" cols="24" name="address" required></textarea></td>
            </tr>

    		
    		<tr>
    			<td><?php wp_nonce_field( 'new-patient' ); ?></td>
    		</tr>
	    	<tr>
    			<th><label></label></th>
    			<td><input type="submit" name="submit_patient" value="Save Patient"></td>
    		</tr>
    	</table>
    </form>
</div>