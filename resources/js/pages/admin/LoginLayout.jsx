import { Route, Routes } from 'react-router-dom';
import Login from './Login';

const LoginLayout = () => {
  return (
    <div className="client">
      <Routes>
        <Route path="*" element={<Login />}  />
      </Routes>
    </div>
  );
}

export default LoginLayout;