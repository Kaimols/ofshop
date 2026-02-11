
setTimeout(() => {
  $('#preloader').fadeOut('slow');
}, 800)

Fancybox.bind("[data-fancybox]", {
  // Your custom options
});


CategoryCheck();

const options = {
  placement: 'center',
  backdrop: 'dynamic',
  backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
  closable: true,
  onHide: () => {
      console.log('modal is hidden');
  },
  onShow: () => {
      console.log('modal is shown');
  },
  onToggle: () => {
      console.log('modal has been toggled');
  }
};

const thumbnail_target = document.getElementById('editthumb-modal');
const ethumb_modal = new Modal(thumbnail_target, options);


function EditThumbnail(id){
  $('#postid').val(id);
  ethumb_modal.show();
  
}


$("#update-thumbnail-form").on('submit',(function(e) {
  e.preventDefault();
  $.ajax({
    url: "/rest/posts/api?thumbnail",
    type: "POST",
    data:  new FormData(this),
    enctype: 'multipart/form-data',
    contentType: false,
    cache: false,
    processData: false,
    success: function(response){
      const result = JSON.parse(response);
      var status = result.status;
      var message = result.message;
  
      if(status == 'error'){
        Toastify({
            text: message,
            duration: 2500,
            position: "right", 
            style: {
                background: "red",
            }
        }).showToast();
      }else{
        Toastify({
            text: message,
            duration: 2500,
            position: "right", 
            style: {
                background: "#ed51c1",
            }
        }).showToast();
       
        setTimeout(() => {
          location.reload();
        }, 1500)
      }
    },
    error: function(data)
      {
        console.log("error");
            console.log(data);
      }
   });
}));

function ShowThumbnail(id){
  if(!id){
    Toastify({
        text: 'Invalid post id!',
        duration: 2500,
        position: "right", 
        style: {
            background: "red",
        }
    }).showToast();
    return;
  }else{
    $.ajax({
      url: "rest/posts/api?showthumb",
      type: "POST",
      data: {
        postid: id
      },
      cache: false,
      success: function(response){
        const result = JSON.parse(response);
        var status = result.status;
        var message = result.message;
    
        if(status == 'error'){
          Toastify({
              text: message,
              duration: 2500,
              position: "right", 
              style: {
                  background: "red",
              }
          }).showToast();
        }else{
          window.open('/uploads/'+result.image, '_blank');
        }
      }
    });


  }


}

// Toggle Free Post (Admin only)
function ToggleFreePost(id) {
  if (!id) {
    Toastify({
      text: 'Invalid post id!',
      duration: 2500,
      position: "right",
      style: { background: "red" }
    }).showToast();
    return;
  }

  $.ajax({
    url: "/api/toggle_free_post.php",
    type: "POST",
    data: { post_id: id },
    dataType: 'json',
    success: function(response) {
      if (response.success) {
        Toastify({
          text: response.message,
          duration: 2500,
          position: "right",
          style: { background: response.is_free ? "#22c55e" : "#eab308" }
        }).showToast();
        
        // Update button text and color
        const toggleBtn = document.getElementById('free-toggle-' + id);
        if (toggleBtn) {
          if (response.is_free) {
            toggleBtn.innerHTML = '<i class="fa-solid fa-lock-open mr-2"></i>Free deaktivieren';
            toggleBtn.classList.remove('text-yellow-400');
            toggleBtn.classList.add('text-green-400');
          } else {
            toggleBtn.innerHTML = '<i class="fa-solid fa-unlock mr-2"></i>Als Free markieren';
            toggleBtn.classList.remove('text-green-400');
            toggleBtn.classList.add('text-yellow-400');
          }
        }
        
        // Reload after short delay to show updated post
        setTimeout(() => { location.reload(); }, 1500);
      } else {
        Toastify({
          text: response.error || 'Ein Fehler ist aufgetreten',
          duration: 2500,
          position: "right",
          style: { background: "red" }
        }).showToast();
      }
    },
    error: function() {
      Toastify({
        text: 'Netzwerkfehler',
        duration: 2500,
        position: "right",
        style: { background: "red" }
      }).showToast();
    }
  });
}

function pushPost(id){
  if(!id){
      Toastify({
          text: 'Invalid post id!',
          duration: 2500,
          position: "right", 
          style: {
              background: "red",
          }
      }).showToast();
      return;
  }else{
  
    Swal.fire({
      title: 'Willst du den Post pushen?',
      showCancelButton: true,
      confirmButtonText: 'Yes',
    }).then((result) => {
      
      if (result.isConfirmed) {
        $.ajax({
          url: "rest/posts/api?push",
          type: "POST",
          data: {
            postid: id,
          },
          cache: false,
          success: function(response){
            const result = JSON.parse(response);
            var status = result.status;
            var message = result.message;
        
            if(status == 'error'){
              Toastify({
                  text: message,
                  duration: 2500,
                  position: "right", 
                  style: {
                      background: "red",
                  }
              }).showToast();
            }else{
              Toastify({
                  text: message,
                  duration: 2500,
                  position: "right", 
                  style: {
                      background: "#ed51c1",
                  }
              }).showToast();
              setTimeout(() => {
                  location.reload();
              }, 1500)
              
            }
          }
        });
      }
    })

      

  }
}

function ChangePostName(id){
  if(!id){
    Toastify({
        text: 'Invalid post id!',
        duration: 2500,
        position: "right", 
        style: {
            background: "red",
        }
    }).showToast();
    return;
  }else{

    Swal.fire({
      title: 'Change name', 
      html: `<input id="name" type="text" class="swal2-input" placeholder="New name.." />`,
      cancelButtonColor: "#FF0000",
      confirmButtonColor: "#626ED4",
      showCancelButton: true, 
      confirmButtonText: 'Save',
      cancelButtonText: 'Dismiss',
      focusConfirm: false,
    preConfirm: () => {
      var name = Swal.getPopup().querySelector('#name').value
      
      if (!name) {
        Swal.showValidationMessage(`Please fill all fields.`)
      }
      
      return {name:name}
      }
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
        icon: 'question',
        title: 'Are you sure?',
        text: 'You want to change post name to: "'+result.value.name+'"',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: `Dismiss`,
        cancelButtonColor: "#FF0000",
        }).then((res) => {
          if(res.isConfirmed){
            const csrf = $('#token').val();
            $.ajax({
              url: "rest/posts/api?changename",
              type: "POST",
              data: {
                name: result.value.name,
                postid: id,
                csrf
              },
              cache: false,
              success: function(response){
                const result = JSON.parse(response);
                var status = result.status;
                var message = result.message;
            
                if(status == 'error'){
                  Toastify({
                      text: message,
                      duration: 2500,
                      position: "right", 
                      style: {
                          background: "red",
                      }
                  }).showToast();
                }else{
                  Toastify({
                      text: message,
                      duration: 2500,
                      position: "right", 
                      style: {
                          background: "#ed51c1",
                      }
                  }).showToast();
                  setTimeout(() => {
                      location.reload();
                  }, 2000)
                  
                }
              }
            });
          }
        }) 
      }
    });
  
  }
}


function ChangePassword(){
  Swal.fire({
    title: 'Change password', 
    html: `<input id="currentpass" type="password" class="swal2-input" placeholder="Current password" />
            <input id="newpass" type="password" class="swal2-input" placeholder="New password" /> 
            <input id="cnewpass" type="password" class="swal2-input" placeholder="Confirm new password" /> 
    `,
    cancelButtonColor: "#FF0000",
    confirmButtonColor: "#626ED4",
    showCancelButton: true, 
    confirmButtonText: 'Change',
    cancelButtonText: 'Dismiss',
    focusConfirm: false,
  preConfirm: () => {
    var currentpass = Swal.getPopup().querySelector('#currentpass').value
    var newpass = Swal.getPopup().querySelector('#newpass').value
    var cnewpass = Swal.getPopup().querySelector('#cnewpass').value
    if (!currentpass || !newpass || !cnewpass) {
      Swal.showValidationMessage(`Please fill all required fields!`)
    }
    if(newpass != cnewpass){
      Swal.showValidationMessage(`The new passwords do not match!`)
    }
    
    return {currentpass:currentpass, newpass:newpass, cnewpass:cnewpass}
    }
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
      icon: 'question',
      title: 'Are you sure?',
      text: 'You want to change your password? Current: "'+result.value.currentpass+'", New: "'+result.value.newpass+'"',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      cancelButtonText: `Dismiss`,
      cancelButtonColor: "#FF0000",
      }).then((res) => {
        if(res.isConfirmed){
          const csrf = $('#token').val();
          $.ajax({
            url: "rest/user/api?changepass",
            type: "POST",
            data: {
              currentpass: result.value.currentpass,
              newpass: result.value.newpass,
              cnewpass: result.value.cnewpass,
              csrf
            },
            cache: false,
            success: function(response){
              const result = JSON.parse(response);
              var status = result.status;
              var message = result.message;
          
              if(status == 'error'){
                Toastify({
                    text: message,
                    duration: 2500,
                    position: "right", 
                    style: {
                        background: "red",
                    }
                }).showToast();
              }else{
                Toastify({
                    text: message,
                    duration: 2500,
                    position: "right", 
                    style: {
                        background: "#ed51c1",
                    }
                }).showToast();
                setTimeout(() => {
                    location.reload();
                }, 2000)
                
              }
            }
          });
        }
      }) 
    }
  });
}


function CloseGallery(){
  history.back();
}


function BanPostUser(id){
  if(!id){
    Toastify({
        text: 'Invalid post id!',
        duration: 2500,
        position: "right", 
        style: {
            background: "red",
        }
    }).showToast();
    return;
  }else{

    Swal.fire({
      title: 'Ban Author', 
      html: `<input id="reason" type="text" class="swal2-input" placeholder="Reason" />
              <input id="expires" type="datetime-local" class="swal2-input" placeholder="Expires" /> 
      `,
      cancelButtonColor: "#FF0000",
      confirmButtonColor: "#626ED4",
      showCancelButton: true, 
      confirmButtonText: 'Ban',
      cancelButtonText: 'Dismiss',
      focusConfirm: false,
    preConfirm: () => {
      var reason = Swal.getPopup().querySelector('#reason').value
      var expires = Swal.getPopup().querySelector('#expires').value
      if (!reason || !expires) {
        Swal.showValidationMessage(`Please fill all fields.`)
      }
      
      return {reason:reason, expires:expires}
      }
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
        icon: 'question',
        title: 'Are you sure?',
        text: 'You want to ban user for reason: "'+result.value.reason+'" until '+result.value.expires+'"',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: `Dismiss`,
        cancelButtonColor: "#FF0000",
        }).then((res) => {
          if(res.isConfirmed){
            const csrf = $('#token').val();
            $.ajax({
              url: "rest/posts/api?banauthor",
              type: "POST",
              data: {
                reason: result.value.reason,
                expires: result.value.expires,
                postid: id,
                csrf
              },
              cache: false,
              success: function(response){
                const result = JSON.parse(response);
                var status = result.status;
                var message = result.message;
            
                if(status == 'error'){
                  Toastify({
                      text: message,
                      duration: 2500,
                      position: "right", 
                      style: {
                          background: "red",
                      }
                  }).showToast();
                }else{
                  Toastify({
                      text: message,
                      duration: 2500,
                      position: "right", 
                      style: {
                          background: "#ed51c1",
                      }
                  }).showToast();
                  setTimeout(() => {
                      location.reload();
                  }, 2000)
                  
                }
              }
            });
          }
        }) 
      }
    });
  
  }
}

function ClearPostLikes(id){
  if(!id){
    Toastify({
        text: 'Invalid post id!',
        duration: 2500,
        position: "right", 
        style: {
            background: "red",
        }
    }).showToast();
    return;
  }else{

  Swal.fire({
    title: 'Do you want to clear likes for this post?',
    showCancelButton: true,
    confirmButtonText: 'Yes',
  }).then((result) => {
    
    if (result.isConfirmed) {
      $.ajax({
        url: "rest/posts/api?clearlikes",
        type: "POST",
        data: {
          postid: id,
        },
        cache: false,
        success: function(response){
          const result = JSON.parse(response);
          var status = result.status;
          var message = result.message;
      
          if(status == 'error'){
            Toastify({
                text: message,
                duration: 2500,
                position: "right", 
                style: {
                    background: "red",
                }
            }).showToast();
          }else{
            Toastify({
                text: message,
                duration: 2500,
                position: "right", 
                style: {
                    background: "#ed51c1",
                }
            }).showToast();
            setTimeout(() => {
                location.reload();
            }, 2000)
            
          }
        }
      });
    }
  })
  }
}

//GET LOCATION AFTER RELOAD
document.addEventListener("DOMContentLoaded", function(event) { 
  var scrollpos = localStorage.getItem('scrollpos');
  if (scrollpos) window.scrollTo(0, scrollpos);
});

window.onbeforeunload = function(e) {
  localStorage.setItem('scrollpos', window.scrollY);
};


$(function () {
  
  var ImgsPreview = function (input, imgPreviewPlaceholder) {
    if (input.files) {
      var filesAmount = input.files.length;
      for (i = 0; i < filesAmount; i++) {
        var reader = new FileReader();
        reader.onload = function (event) {
          $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
        }
        reader.readAsDataURL(input.files[i]);
      }
    }
  };
  $('#thumbnail').on('change', function () {
    ImgsPreview(this, 'div.imgs-preview');
  });
});

$(function () {
  
  var AllImgsPreview = function (input, imgPreviewPlaceholder) {
    if (input.files) {
      var filesAmount = input.files.length;
      for (i = 0; i < filesAmount; i++) {
        var reader = new FileReader();
        reader.onload = function (event) {
          $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
        }
        reader.readAsDataURL(input.files[i]);
      }
    }
  };
  $('#images').on('change', function () {
    AllImgsPreview(this, 'div.allimgs-preview');
  });
});

function RedirectToCategory(id){
  window.location = 'home?c='+id;
}

function CategoryCheck(){
  let searchParams = new URLSearchParams(window.location.search);
  let param = searchParams.get('c');
  console.log(param)

  if(!param){ 
    $('#category-0').toggleClass('bg-[#1E1E22]');
    $('#category-0').addClass('active-category');
  }else{ 
    $('#category-'+param).toggleClass('bg-[#1E1E22]');
    $('#category-'+param).addClass('active-category');
  }

}

function FetchFromCategory(id){
    location.href = '?c='+id;
}

$('.like-btn').on('click', function() {
  var postid = $(this).data("post");
    $post = $(this);

  console.log(postid)

  $.ajax({
    url: 'rest/posts/api?like',
    type: 'POST',
    data: {
      postid:postid
    },
    success: function(response){
      const result = JSON.parse(response);
      var status = result.status;
      var message = result.message;
  
      if(status == 'error'){
        Toastify({
            text: message,
            duration: 2500,
            position: "right", 
            style: {
                background: "red",
            }
        }).showToast();
      }else{
        // Stelle sicher, dass likes immer eine positive Zahl ist
        const likes = Math.max(0, parseInt(result.likes) || 0);
        $('#likes-'+postid).text(likes);
        $post.addClass('hidden');
        $post.siblings().removeClass('hidden');
      }
    }
  });
})

$('.unlike-btn').on('click', function() {
  var postid = $(this).data("post");
    $post = $(this);

  console.log(postid)

  $.ajax({
    url: 'rest/posts/api?unlike',
    type: 'POST',
    data: {
      postid:postid
    },
    success: function(response){
      const result = JSON.parse(response);
      var status = result.status;
      var message = result.message;
  
      if(status == 'error'){
        Toastify({
            text: message,
            duration: 2500,
            position: "right", 
            style: {
                background: "red",
            }
        }).showToast();
      }else{
        // Stelle sicher, dass likes immer eine positive Zahl ist
        const likes = Math.max(0, parseInt(result.likes) || 0);
        $('#likes-'+postid).text(likes);
        $post.addClass('hidden');
        $post.siblings().removeClass('hidden');
      }
    }
  });
})


function AddCategory(){
    Swal.fire({
        title: 'Add Category', 
        html: `<input id="cemoji" class="swal2-input" placeholder="Category emoji" />
                <input id="cname" class="swal2-input" placeholder="Category name" /> 
        `,
        cancelButtonColor: "#FF0000",
        confirmButtonColor: "#626ED4",
        showCancelButton: true, 
        confirmButtonText: 'Save',
        cancelButtonText: 'Dismiss',
        focusConfirm: false,
      preConfirm: () => {
        var cemoji = Swal.getPopup().querySelector('#cemoji').value
        var cname = Swal.getPopup().querySelector('#cname').value
        if (!cemoji || !cname) {
          Swal.showValidationMessage(`Please select emoji or name.`)
        }
        
        return {cemoji:cemoji, cname:cname}
        }
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
          icon: 'question',
          title: 'Are you sure?',
          text: 'You want to add category "'+result.value.cemoji+' '+result.value.cname+'"',
          showCancelButton: true,
          confirmButtonText: 'Yes',
          cancelButtonText: `Dismiss`,
          cancelButtonColor: "#FF0000",
          }).then((res) => {
            if(res.isConfirmed){
              const csrf = $('#token').val();
              $.ajax({
                url: "rest/categories/api?create",
                type: "POST",
                data: {
                  cemoji: result.value.cemoji,
                  cname: result.value.cname,
                  csrf
                },
                cache: false,
                success: function(response){
                  const result = JSON.parse(response);
                  var status = result.status;
                  var message = result.message;
              
                  if(status == 'error'){
                    Toastify({
                        text: message,
                        duration: 2500,
                        position: "right", 
                        style: {
                            background: "red",
                        }
                    }).showToast();
                  }else{
                    Toastify({
                        text: message,
                        duration: 2500,
                        position: "right", 
                        style: {
                            background: "#ed51c1",
                        }
                    }).showToast();
                    setTimeout(() => {
                        location.reload();
                    }, 2000)
                    
                  }
                }
              });
            }
          }) 
        }
      });
}

function DeleteCategory(id){
  if(!id){
      Toastify({
          text: 'Invalid category id!',
          duration: 2500,
          position: "right", 
          style: {
              background: "red",
          }
      }).showToast();
      return;
  }else{
  
    Swal.fire({
      title: 'Do you want to delete this category?',
      showCancelButton: true,
      confirmButtonText: 'Yes',
    }).then((result) => {
      
      if (result.isConfirmed) {
        const csrf = $('#token').val();
        $.ajax({
          url: "rest/categories/api?delete",
          type: "POST",
          data: {
            id,
            csrf,
          },
          cache: false,
          success: function(response){
            const result = JSON.parse(response);
            var status = result.status;
            var message = result.message;
            
            if(status == 'error'){
              Toastify({
                  text: message,
                  duration: 2500,
                  position: "right", 
                  style: {
                      background: "red",
                  }
              }).showToast();
            }else{
              Toastify({
                  text: message,
                  duration: 2500,
                  position: "right", 
                  style: {
                      background: "#ed51c1",
                  }
              }).showToast();
              setTimeout(() => {
                  location.reload();
              }, 1500)
              
            }
          }
        });
      }
    })

      

  }
}


function DeletePost(id){
    if(!id){
        Toastify({
            text: 'Invalid post id!',
            duration: 2500,
            position: "right", 
            style: {
                background: "red",
            }
        }).showToast();
        return;
    }else{
    
      Swal.fire({
        title: 'Do you want to delete this post?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
      }).then((result) => {
        
        if (result.isConfirmed) {
          $.ajax({
            url: "rest/posts/api?delete",
            type: "POST",
            data: {
              postid: id,
            },
            cache: false,
            success: function(response){
              const result = JSON.parse(response);
              var status = result.status;
              var message = result.message;
          
              if(status == 'error'){
                Toastify({
                    text: message,
                    duration: 2500,
                    position: "right", 
                    style: {
                        background: "red",
                    }
                }).showToast();
              }else{
                Toastify({
                    text: message,
                    duration: 2500,
                    position: "right", 
                    style: {
                        background: "#ed51c1",
                    }
                }).showToast();
                setTimeout(() => {
                    location.reload();
                }, 1500)
                
              }
            }
          });
        }
      })

        

    }
}


function SignOut() {
  $.ajax({
    url: 'rest/user/logout',
    type: 'POST',
    data: {
      logout:'logout'
    },
    cache: false,
    success: function (response) {
      const result = JSON.parse(response);
      var status = result.status;
      var message = result.message;

      if (status == 'error') {
        noty(message, 'error')
      } else {
        Toastify({
          text: 'You are successfully signed out. Redirecting..',
          duration: 2500,
          position: "right", 
          style: {
              background: "#ed51c1",
          }
        }).showToast();
        setTimeout(function () {
          window.location.replace('./login');
        }, 2000);
      }
    },
  });
  
}