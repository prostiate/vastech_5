<template>
    <div class="card">
            
            <div class="card-body">
                <h3> Contact Info </h3>
                <div class="row my-1">
                    <div class="col-sm-2">
                        Display Name
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" id="display_name" name="display_name">  
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-sm-2">
                        Contact Type*
                    </div>
                    <div class="col-sm-6">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="contact_type1" name="contact_type1" value="1">
                            <label class="form-check-label" for="contact_type1">Customer</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="contact_type2" name="contact_type2" value="1">
                            <label class="form-check-label" for="contact_type2">Vendor</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="contact_type3" name="contact_type3" value="1">
                            <label class="form-check-label" for="contact_type3">Employee</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="contact_type4" name="contact_type4" value="1">
                            <label class="form-check-label" for="contact_type4">Others</label>
                        </div>
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-sm-2">
                        Contact Group
                    </div>
                    <div class="col-sm-6">
                        <select class="form-control form-control-sm" id="contactForm">
                            <option selected>Select..</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>  
                    </div>
                </div>
                <h3> General Information</h3>
                <div class="row my-1">
                    <div class="col-sm-2">
                       Contact Name
                    </div>
                    <div class="col-sm-6 row">
                        <div class="col-sm-3">
                            <select class="form-control form-control-sm" id="contact_status" name="contact_status">
                                <option selected>(Empty)</option>
                                <option value="1">Mr.</option>
                                <option value="2">Ms.</option>
                                <option value="3">Mrs.</option>
                            </select> 
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="contact_first_name" name="contact_first_name">  
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="contact_middle_name" name="contact_middle_name">  
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="contact_last_name" name="contact_last_name">  
                        </div>
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-sm-2">
                        Handphone
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" id="contact_handphone" name="contact_handphone">  
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-sm-2">
                        Identity
                    </div>
                    <div class="col-sm-6 row">
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" id="contact_identity_type" name="contact_identity_type">
                                <option selected>(Empty)</option>
                                <option value="KTP">KTP</option>
                                <option value="SIM">SIM</option>
                                <option value="Passport">Passport</option>
                            </select> 
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-sm" id="contact_identity_id" name="contact_identity_id" placeholder="Identity Number">  
                        </div>
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-sm-2">
                        Email
                    </div>
                    <div class="col-sm-6">
                        <input type="email" class="form-control form-control-sm" id="email" name="email">  
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-sm-2">
                        Another Info
                    </div>
                    <div class="col-sm-6">
                        <textarea class="form-control" id="another_info" name="another_info" rows="2"></textarea>    
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-sm-2">
                        Company Name
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" id="company_name" name="company_name">  
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-sm-2">
                        Telephone
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" id="telephone" name="telephone">  
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-sm-2">
                        Fax
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" id="fax" name="fax">  
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-sm-2">
                        NPWP
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" id="npwp" name="npwp">  
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-sm-2">
                        Billing Address
                    </div>
                    <div class="col-sm-6">
                        <textarea class="form-control" id="billing_address" name="billing_address" rows="2"></textarea>
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-sm-2">
                        Shoping Address
                    </div>
                    <div class="col-sm-6">
                        <textarea class="form-control" id="shipping_address" name="shipping_address" rows="2"></textarea>    
                    </div>
                </div>
                <div class= "row my-3">
                    <div class="col-sm-8">
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-light">Cancel</button>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success">Add</button>                                
                            </div>     
                        </div> 
                    </div>                      
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
