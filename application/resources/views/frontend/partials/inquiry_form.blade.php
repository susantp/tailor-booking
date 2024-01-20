<div class="widget widget-background-white">
    <h3 class="widgettitle">Inquire Form</h3>
    <form method="post" class="inquiry-form">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" class="form-control required" name="full_name">
        </div>
        <div class="form-group">
            <label>E-mail</label>
            <input type="text" class="form-control required email" name="email">
        </div>
        <div class="form-group">
            <label>Subject</label>
            <input type="text" class="form-control required" name="subject">
        </div>             
        <div class="form-group">
            <label>Message</label>
            <textarea class="form-control required" rows="4" name="message"></textarea>
        </div>                              
        <div class="form-group-btn">
            <button type="submit" id="submit" class="btn btn-primary btn-block btn-large">Send Message</button>
            <span class="msg error_message"></span>
        </div>
    </form>
</div>