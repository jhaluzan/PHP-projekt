<?php
print '
<div class="form-container">
    <h1>Contact Us</h1>
    
    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d21330.597108746497!2d-121.97376901989139!3d37.370619603344245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fca2702c480db%3A0x76527847b95e08c9!2sNVIDIA!5e0!3m2!1shr!2shr!4v1729443904306!5m2!1shr!2shr" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <br> <br>
    <div class="form">
        <form action="#" method="post">
            <div class="form-group">
                <label for="fname">First Name:</label>
                <input type="text" id="fname" name="fname" required>
            </div>
            <br>
            <div class="form-group">
                <label for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname" required>
            </div>
            <br>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <br>
            <div class="form-group">
                <label for="country">Country:</label>
                <select id="country" name="country">
                    <option value="Croatia">Croatia</option>
                    <option value="Germany">Germany</option>
                    <option value="UK">United Kingdom</option>
                    <option value="USA">USA</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" cols="50"></textarea>
            </div>
            <br>
            <button type="submit">Submit</button>
        </form>
    </div>
</div>'
?>