import { useSelector, useDispatch } from 'react-redux';
import { adminLogout } from '@/store/auth';

const AdminLayout = () => {
  const { version } = useSelector((state) => state.app);
  const { me } = useSelector((state) => state.auth);
  const dispatch = useDispatch();

  const handleLogout = () => {
    dispatch(adminLogout());
  };

  return (
    <div className="admin">
      { version }
      <br />
      { me.name } ({ me.email })
      <br />
      <button onClick={handleLogout}>Log Out</button>
    </div>
  );
}

export default AdminLayout;