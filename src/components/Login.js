import React,{ useState } from "react";
function Login({login}) {

    const state={
      email:'',
      password:''
    }
    const [val,setval]=useState(state)

    const onchange=(e)=>{
      const {name,value}=e.target;
      setval({...val,[name]:value});
    }

    const onsubmited=(e)=>{
      e.preventDefault();

      
      if(val.email && val.password){
        fetch("http://localhost/api%20crud/Login.php",{
          method:"POST",
          headers:{"Content-Type":"application/json"},
          body:JSON.stringify({
            email:val.email,
            password:val.password
          })
        }).then(res=>{
          return res.json();
        }).then(data=>{
          if(data.success){
            login(true)
            localStorage.setItem('email',data.email)
          }else{
            alert(data.message);
          }
        }).catch(e=>{
          console.log(e)
        })
      }


    }


  return (

    <form onSubmit={onsubmited}>
      <h2>Login</h2>
      <label htmlFor="email">Email</label>
      <input
        type="email"
        id="_name"
        placeholder="Enter email"
        name="email"
        onChange={onchange}
        required
      />
      <label htmlFor="password">Pasword</label>
      <input
        type="password"
        id="_email"
        name="password"
        onChange={onchange}
        placeholder="password"
        required
      />
      <input type="submit" value="login" />
    </form>
  );
};

export default Login;