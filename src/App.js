import { Provider } from "./Context";
import React,{useState} from "react";
import Login from "./components/Login";

import Form from "./components/Form";
import UserList from "./components/UserList";

import { Actions } from "./Actions";

function App() {
  const i={
    i:false
  }
  const [val,setVal]=useState(i);
  const data = Actions();

  const login=(e)=>{
    setVal({i:e});
  }
  return (
    <>
    
      {
        val.i ? (

          <Provider value={data}>
            
            <div className="App">
              <h1>meth commande</h1>
              <div className="wrapper">

              
                <section className="left-side">

                  <Form />
                </section>
                <section className="right-side">
                  <UserList />
                </section>
              </div>
            </div>
          </Provider>

        ) : (

          <Login login={login}/>

        )
      }
    
    </>
    
  );
}

export default App;