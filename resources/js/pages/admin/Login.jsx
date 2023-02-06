import { useDispatch } from 'react-redux';
import { adminLogin } from '@/store/auth';

const Login = () => {
  const dispatch = useDispatch();

  const handleLogin = () => {
    dispatch(adminLogin({
      data: {
        email: 'admin@div-art.com',
        password: '123123123',
      }
    }));
  };

  return (
    <div className="client">
      <button onClick={handleLogin}>Log In</button>
    </div>
  );
}

export default Login;