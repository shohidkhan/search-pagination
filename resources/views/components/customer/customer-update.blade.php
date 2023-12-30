<div class="modal fade" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Customer</h6>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerNameUpdate">

                                <label class="form-label">Customer Email *</label>
                                <input type="text" class="form-control mb-2" id="customerEmailUpdate">

                                <label class="form-label">Customer Mobile *</label>
                                <input type="text" class="form-control mb-2" id="customerMobileUpdate">

                                <input type="hidden" class="d-none" id="customerID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn btn-danger" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="updateCustomer()" id="update-btn" class="btn btn-success">Update</button>
            </div>
        </div>
    </div>
</div>


<script>



    async function fillUpUpdateForm(id){
        let customerId=document.getElementById('customerID').value=id;
        showLoader();
        try{
            let res= await axios.get(`/customers/${id}`);
            const customerData=res.data;
            document.getElementById("customerNameUpdate").value=customerData.name;
            document.getElementById("customerEmailUpdate").value=customerData.email;
            document.getElementById("customerMobileUpdate").value=customerData.mobile;

            openModal('update-modal');
        }catch (error) {
            console.error('Error fetching customer data:', error);
        } finally {
            hideLoader();
        }
    }


    async function updateCustomer(){
        let name=document.getElementById("customerNameUpdate").value;
        let email=document.getElementById("customerEmailUpdate").value;
        let mobile=document.getElementById("customerMobileUpdate").value;

        if(!name || !email || !mobile){
            alert("All fields are required!");
            return;
        }
        try{
            showLoader();
            closeModal('update-modal');
            const customerObj={
                name:name,
                email:email,
                mobile:mobile
            }
            const customerId=document.getElementById("customerID").value;
            let res=await axios.put(`/customers/${customerId}`,customerObj);
            if(res.data["status"]==="success"){
                document.getElementById("update-form").reset();
                getCustomersLists()
                alert(res.data["message"]);
            }else{
                alert(res.data["message"]);
            }
        }catch(error){
            console.error('Error updating customer:', error);
        }finally{
            hideLoader();
        }
    }
</script>
