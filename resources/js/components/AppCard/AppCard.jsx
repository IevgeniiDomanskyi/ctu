import Card from '@mui/material/Card'
import CardContent from '@mui/material/CardContent'

const AppCard = ({children, ...props}) => {
  return (
    <Card {...props}>
      <CardContent>
        { children }
      </CardContent>
    </Card>
  )
}

export default AppCard