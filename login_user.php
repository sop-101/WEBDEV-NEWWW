*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(
        135deg,
        #0f172a,
        #172554,
        #1e293b
    );
    padding:20px;
}

.login-container{
    width:100%;
    max-width:500px;
    background:#ffffff;
    border-radius:25px;
    padding:45px;
    box-shadow:0 20px 60px rgba(0,0,0,.25);
    animation:fadeIn .5s ease;
}

.logo-section{
    text-align:center;
    margin-bottom:25px;
}

.logo-icon{
    width:80px;
    height:80px;
    margin:auto;
    border-radius:50%;
    background:linear-gradient(
        135deg,
        #e94560,
        #ff6b81
    );
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:36px;
    margin-bottom:15px;
}

.logo-section h1{
    font-size:42px;
    color:#0f172a;
    font-weight:800;
}

.logo-section p{
    color:#64748b;
    margin-top:5px;
}

.login-title{
    text-align:center;
    margin-top:10px;
    margin-bottom:10px;
    color:#0f172a;
}

.subtitle{
    text-align:center;
    color:#64748b;
    margin-bottom:30px;
}

.error-message{
    background:#fee2e2;
    color:#b91c1c;
    padding:14px;
    border-radius:10px;
    margin-bottom:20px;
    text-align:center;
}

.form-group{
    margin-bottom:18px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    color:#334155;
    font-weight:600;
}

.form-group input{
    width:100%;
    padding:15px;
    border:2px solid #e2e8f0;
    border-radius:12px;
    font-size:15px;
    transition:.3s;
}

.form-group input:focus{
    outline:none;
    border-color:#e94560;
    box-shadow:0 0 0 5px rgba(233,69,96,.15);
}

.show-password{
    margin-bottom:20px;
    color:#475569;
    font-size:14px;
}

.btn-login{
    width:100%;
    padding:16px;
    border:none;
    border-radius:12px;
    background:linear-gradient(
        135deg,
        #e94560,
        #ff6b81
    );
    color:white;
    font-size:16px;
    font-weight:700;
    cursor:pointer;
    transition:.3s;
}

.btn-login:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 25px rgba(233,69,96,.35);
}

.register-link{
    text-align:center;
    margin-top:25px;
}

.register-link a{
    color:#e94560;
    text-decoration:none;
    font-weight:700;
}

.admin-link{
    text-align:center;
    margin-top:12px;
}

.admin-link a{
    color:#64748b;
    text-decoration:none;
}

.admin-link a:hover{
    color:#e94560;
}

.login-footer{
    margin-top:25px;
    text-align:center;
    color:#94a3b8;
    font-size:13px;
}

@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(20px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

@media(max-width:600px){

    .login-container{
        padding:30px;
    }

    .logo-section h1{
        font-size:32px;
    }

}
