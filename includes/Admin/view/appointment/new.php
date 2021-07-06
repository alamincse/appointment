<div class="wrap">
	<h2 class="wp-heading-inline">New Appointment</h2>
    <form action="" method="POST">
    	<table>
            <tr>
                <th><label for="patient_name">Patient Name</label></th>
                <!-- <td><input type="text" id="patient_name" name="patient_name" required></td> -->
                <td>
                    <select name="patient_name" id="patient_name" required>
                            <option value="">Select Patient</option>
                        <?php foreach( $patients as $patient ) : ?>
                            <option value="<?php echo $patient->id; ?>"><?php echo $patient->patient_name; ?></option>
                        <?php endforeach; ?>
                    </select>  

                    <a href="<?php echo admin_url( 'admin.php?page=patient-menu&action=new' ); ?>" class="page-title-action"><?php _e( 'Add new patient', 'Enzaime' ); ?></a>
                </td>
            </tr>

    		<tr>
    			<th><label for="dr_name">Select Doctor</label></th>
    			<td>
                    <select name="dr_name" id="dr_name" required>
                            <option value="">Select Doctor</option>
                        <?php foreach( $doctors as $doctor ) : ?>
                            <option value="<?php echo $doctor->id; ?>"><?php echo $doctor->name; ?></option>
                        <?php endforeach; ?>
                    </select>         
                </td>
    		</tr>
    		<tr>
    			<th><label for="patient">Consultation Type</label></th>
    			<td>
                    <select name="cons_type" required>
                        <option value="">Select Consultation Type</option>
                        <option value="physical">Physical Consultation</option>
                        <option value="video">Video Consultation</option>
                    </select>         
                </td>
    		</tr>
           
    		<tr>
    			<th><label for="date">Appointment Date</label></th>
    			<td><input type="date" id="date" name="date" required></td>
    		</tr>

            <tr>
                <th><label for="time">Time Slot</label></th>
                <td><input type="time" id="time" name="time" required></td>
            </tr>

            <tr>
                <th><label for="phone">Phone</label></th>
                <td><input type="text" id="phone" name="phone" required></td>
            </tr>

            <tr>
                <th><label for="desc">Description of Illness</label></th>
                <td><textarea rows="5" cols="24" name="description" required></textarea></td>
            </tr>

    		
    		<tr>
    			<td><?php wp_nonce_field( 'new-appointment' ); ?></td>
    		</tr>
	    	<tr>
    			<th><label></label></th>
    			<td><input type="submit" name="submit_appointment" value="Get Appointment"></td>
    		</tr>
    	</table>
    </form>
</div>